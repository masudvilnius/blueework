<?php
declare(strict_types=1);

// BlueeWork form handler. It stores each submission as a private .xlsx file and emails it to masud@gmail.com.
$httpsRequest = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $httpsRequest,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

$configPath = dirname(__DIR__) . '/private/config.php';
if (!is_file($configPath)) {
    http_response_code(500);
    exit('BlueeWork is not configured yet. Please contact the website administrator.');
}
$config = require $configPath;
$privateRoot = dirname(__DIR__) . '/private';
$storageRoot = $privateRoot . '/storage';
$submissionDir = $storageRoot . '/submissions';
$uploadRoot = $storageRoot . '/uploads';
$logDir = $storageRoot . '/logs';

function bwRespond(int $status, string $title, string $message, string $reference = ''): never
{
    http_response_code($status);
    $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    $safeReference = htmlspecialchars($reference, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>' . $safeTitle . ' — BlueeWork</title><style>:root{--navy:#073B82;--yellow:#FFB900;--ink:#202B3C;--muted:#63758a}*{box-sizing:border-box}body{margin:0;background:#f1f6fc;font-family:Inter,system-ui,-apple-system,Segoe UI,sans-serif;color:var(--ink);min-height:100vh;display:grid;place-items:center;padding:20px}.card{max-width:620px;width:100%;background:white;border:1px solid #dce6ef;border-radius:24px;padding:clamp(24px,5vw,44px);box-shadow:0 18px 50px #073b8218}.brand{font-size:1.25rem;font-weight:900;color:var(--navy);margin-bottom:30px;letter-spacing:-.04em}.brand b{display:inline-grid;place-items:center;background:var(--yellow);border-radius:10px;width:34px;height:34px;margin-right:8px;color:var(--navy)}h1{color:var(--navy);font-size:clamp(1.8rem,5vw,2.4rem);line-height:1.1;letter-spacing:-.04em;margin:0 0 14px}.body{color:var(--muted);line-height:1.7}.ref{background:#f1f6fc;border-radius:12px;padding:12px 15px;margin:20px 0;color:var(--navy);font-weight:800;overflow-wrap:anywhere}.btn{display:inline-block;margin-top:12px;background:var(--yellow);color:var(--navy);font-weight:800;text-decoration:none;border-radius:12px;padding:13px 18px}</style></head><body><main class="card"><div class="brand"><b>BW</b>BlueeWork</div><h1>' . $safeTitle . '</h1><div class="body">' . $safeMessage . '</div>' . ($reference !== '' ? '<div class="ref">Submission reference: ' . $safeReference . '</div>' : '') . '<a class="btn" href="/">Return to BlueeWork</a></main></body></html>';
    exit;
}

function bwLog(string $message, string $logDir): void
{
    if (!is_dir($logDir)) @mkdir($logDir, 0750, true);
    $line = gmdate('c') . ' ' . preg_replace('/[\r\n]+/', ' ', $message) . "\n";
    @file_put_contents($logDir . '/submission-events.log', $line, FILE_APPEND | LOCK_EX);
}

function bwEnsureDir(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0750, true) && !is_dir($path)) {
        throw new RuntimeException('Private storage directory could not be created.');
    }
    if (!is_writable($path)) {
        throw new RuntimeException('Private storage is not writable. Check permissions for the private/storage directory.');
    }
}

function bwCleanString(mixed $value, int $max = 5000): string
{
    if (is_array($value) || is_object($value)) {
        return '';
    }
    $value = trim((string)$value);
    $value = str_replace("\0", '', $value);
    if (strlen($value) > $max) {
        $value = substr($value, 0, $max);
    }
    return $value;
}

function bwRequireFields(array $post, array $fields): void
{
    foreach ($fields as $field => $label) {
        if (bwCleanString($post[$field] ?? '') === '') {
            throw new InvalidArgumentException('Please complete the required field: ' . $label . '.');
        }
    }
}

function bwCheckEmail(string $email, string $label = 'Email address'): void
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
        throw new InvalidArgumentException('Please enter a valid ' . $label . '.');
    }
}

function bwSafeFilename(string $name): string
{
    $name = basename(str_replace('\\', '/', $name));
    $name = preg_replace('/[^A-Za-z0-9._-]+/', '_', $name) ?? 'upload';
    $name = trim($name, '._-');
    return $name !== '' ? substr($name, 0, 100) : 'upload';
}

function bwNormalizeFiles(array $input): array
{
    $items = [];
    if (!isset($input['name'])) return $items;
    if (is_array($input['name'])) {
        $count = count($input['name']);
        for ($i = 0; $i < $count; $i++) {
            $items[] = [
                'name' => (string)($input['name'][$i] ?? ''),
                'type' => (string)($input['type'][$i] ?? ''),
                'tmp_name' => (string)($input['tmp_name'][$i] ?? ''),
                'error' => (int)($input['error'][$i] ?? UPLOAD_ERR_NO_FILE),
                'size' => (int)($input['size'][$i] ?? 0),
            ];
        }
    } else {
        $items[] = [
            'name' => (string)$input['name'], 'type' => (string)($input['type'] ?? ''),
            'tmp_name' => (string)($input['tmp_name'] ?? ''), 'error' => (int)($input['error'] ?? UPLOAD_ERR_NO_FILE),
            'size' => (int)($input['size'] ?? 0),
        ];
    }
    return $items;
}

function bwStoreUploadField(
    string $field,
    string $displayName,
    array $extensions,
    int $maxBytes,
    int $maxFiles,
    bool $required,
    string $uploadDir,
    array &$storedPaths,
    array &$excelRows
): void {
    $input = $_FILES[$field] ?? null;
    $items = $input ? bwNormalizeFiles($input) : [];
    $validItems = [];
    foreach ($items as $item) {
        if ($item['error'] === UPLOAD_ERR_NO_FILE || $item['name'] === '') continue;
        if ($item['error'] !== UPLOAD_ERR_OK) {
            throw new InvalidArgumentException('There was a problem uploading ' . $displayName . '. Please try again.');
        }
        $validItems[] = $item;
    }
    if ($required && count($validItems) === 0) {
        throw new InvalidArgumentException('Please upload ' . $displayName . '.');
    }
    if (count($validItems) > $maxFiles) {
        throw new InvalidArgumentException('Too many files were selected for ' . $displayName . '.');
    }
    if (!$validItems) return;
    bwEnsureDir($uploadDir);
    $savedNames = [];
    foreach ($validItems as $item) {
        if ($item['size'] < 1 || $item['size'] > $maxBytes) {
            throw new InvalidArgumentException($displayName . ' files must be smaller than ' . (int)round($maxBytes / 1024 / 1024) . ' MB each.');
        }
        if (!is_uploaded_file($item['tmp_name'])) {
            throw new InvalidArgumentException('Upload verification failed for ' . $displayName . '.');
        }
        $original = bwSafeFilename($item['name']);
        $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        if (!in_array($extension, $extensions, true)) {
            throw new InvalidArgumentException('Unsupported file type for ' . $displayName . '. Allowed: ' . implode(', ', $extensions) . '.');
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($item['tmp_name']) ?: 'application/octet-stream';
        $allowedMimes = [
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword', 'application/x-ole-storage', 'application/vnd.ms-office', 'application/octet-stream'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/octet-stream'],
            'jpg' => ['image/jpeg'], 'jpeg' => ['image/jpeg'], 'png' => ['image/png'], 'webp' => ['image/webp'],
        ];
        if (!in_array($mime, $allowedMimes[$extension] ?? [], true)) {
            throw new InvalidArgumentException('The contents of a selected ' . $displayName . ' file do not match its file type.');
        }
        $randomName = bin2hex(random_bytes(16)) . '.' . $extension;
        $destination = $uploadDir . '/' . $randomName;
        if (!move_uploaded_file($item['tmp_name'], $destination)) {
            throw new RuntimeException('An uploaded file could not be saved to private storage.');
        }
        @chmod($destination, 0640);
        $storedPaths[] = $destination;
        $savedNames[] = $original . ' (stored privately)';
    }
    $excelRows[] = [$displayName, implode('; ', $savedNames)];
}

function bwXml(string $value): string
{
    return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

function bwColumnName(int $number): string
{
    $name = '';
    while ($number > 0) {
        $mod = ($number - 1) % 26;
        $name = chr(65 + $mod) . $name;
        $number = intdiv($number - $mod, 26);
    }
    return $name;
}

function bwDosTimeDate(): array
{
    $time = getdate();
    $dosTime = (($time['hours'] & 0x1f) << 11) | (($time['minutes'] & 0x3f) << 5) | (int)($time['seconds'] / 2);
    $year = max(1980, (int)$time['year']);
    $dosDate = ((($year - 1980) & 0x7f) << 9) | (($time['mon'] & 0x0f) << 5) | ($time['mday'] & 0x1f);
    return [$dosTime, $dosDate];
}

/** Build a small valid XLSX workbook using PHP's zlib, without Composer packages. */
function bwCreateXlsx(array $rows): string
{
    if (!function_exists('gzdeflate')) {
        throw new RuntimeException('The PHP zlib extension must be enabled to create Excel files.');
    }
    $sheetRows = '';
    $rowNumber = 1;
    foreach ($rows as $row) {
        $cells = '';
        foreach (array_values($row) as $colIndex => $value) {
            $coordinate = bwColumnName($colIndex + 1) . $rowNumber;
            $text = bwXml((string)$value);
            $cells .= '<c r="' . $coordinate . '" t="inlineStr"><is><t xml:space="preserve">' . $text . '</t></is></c>';
        }
        $sheetRows .= '<row r="' . $rowNumber . '">' . $cells . '</row>';
        $rowNumber++;
    }
    $lastRow = max(1, count($rows));
    $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
        . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
        . '<dimension ref="A1:B' . $lastRow . '"/><sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews>'
        . '<cols><col min="1" max="1" width="38" customWidth="1"/><col min="2" max="2" width="90" customWidth="1"/></cols>'
        . '<sheetData>' . $sheetRows . '</sheetData><autoFilter ref="A1:B' . $lastRow . '"/></worksheet>';
    $files = [
        '[Content_Types].xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/></Types>',
        '_rels/.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>',
        'xl/workbook.xml' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Submission" sheetId="1" r:id="rId1"/></sheets></workbook>',
        'xl/_rels/workbook.xml.rels' => '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/></Relationships>',
        'xl/worksheets/sheet1.xml' => $sheetXml,
    ];
    $zip = '';
    $central = '';
    $offset = 0;
    [$dosTime, $dosDate] = bwDosTimeDate();
    foreach ($files as $filename => $contents) {
        $compressed = gzdeflate($contents, 6);
        if ($compressed === false) throw new RuntimeException('Could not compress the Excel workbook.');
        $crc = (int)sprintf('%u', crc32($contents));
        $nameLength = strlen($filename);
        $compressedLength = strlen($compressed);
        $rawLength = strlen($contents);
        $localHeader = pack('VvvvvvVVVvv', 0x04034b50, 20, 0x0800, 8, $dosTime, $dosDate, $crc, $compressedLength, $rawLength, $nameLength, 0);
        $zip .= $localHeader . $filename . $compressed;
        $centralHeader = pack('VvvvvvvVVVvvvvvVV', 0x02014b50, 20, 20, 0x0800, 8, $dosTime, $dosDate, $crc, $compressedLength, $rawLength, $nameLength, 0, 0, 0, 0, 0, $offset);
        $central .= $centralHeader . $filename;
        $offset = strlen($zip);
    }
    $centralOffset = strlen($zip);
    $zip .= $central;
    $zip .= pack('VvvvvVVv', 0x06054b50, 0, 0, count($files), count($files), strlen($central), $centralOffset, 0);
    return $zip;
}

function bwFlattenFields(array $post, string $formType): array
{
    $labels = [
        'name' => 'Full name (as shown on CV)', 'email' => 'Email address', 'phone' => 'Phone number',
        'country' => 'Country / country of residence', 'city' => 'City / region', 'nationality' => 'Nationality',
        'education' => 'Highest education / qualification', 'profile' => 'Portfolio / professional profile URL',
        'accuracyConsent' => 'Candidate accuracy declaration', 'privacyConsent' => 'Candidate privacy and job-matching consent',
        'jobUpdates' => 'Optional job opportunity updates', 'company' => 'Company legal name', 'website' => 'Company website',
        'industry' => 'Industry / business sector', 'registrationNumber' => 'Company registration number', 'contact' => 'Contact person',
        'location' => 'Work country / location', 'startDate' => 'Expected start date', 'experience' => 'Minimum experience',
        'education' => 'Education / certifications', 'languages' => 'Languages required', 'duration' => 'Contract duration',
        'hours' => 'Working hours / shifts', 'salary' => 'Salary / pay range', 'benefits' => 'Benefits / accommodation / transport',
        'visaSupport' => 'Work permit / visa support', 'employerConsent' => 'Employer authorization and contact consent', 'companyPrivacyConsent' => 'Company privacy notice confirmation',
        'legalName' => 'Registered agency legal name', 'tradingName' => 'Agency trading name', 'businessType' => 'Business type',
        'yearEstablished' => 'Year established', 'address' => 'Registered business address', 'representative' => 'Authorised representative',
        'role' => 'Representative role', 'licence' => 'Recruitment licence status', 'licenceNumber' => 'Recruitment licence number',
        'years' => 'Years in recruitment', 'sourceCountries' => 'Countries where candidates are sourced', 'marketsServed' => 'Countries / markets served',
        'trades' => 'Industries and job categories covered', 'candidateProfiles' => 'Typical candidate profiles', 'capacity' => 'Approximate candidates available per month',
        'clientSectors' => 'Employer network / client sectors', 'partnershipModel' => 'Recruitment experience and proposed partnership model',
        'owners' => 'Directors / beneficial owners', 'companyInformationAccurate' => 'Company information accuracy declaration',
        'legalComplianceConsent' => 'Applicable laws compliance declaration', 'dueDiligenceConsent' => 'Partner due diligence consent',
        'logoDisplayConsent' => 'Consent to display agency logo after approval', 'partnerPrivacyConsent' => 'Partner privacy notice confirmation',
    ];
    if ($formType === 'candidate') $labels['education'] = 'Highest education / qualification';
    if ($formType === 'company') $labels['education'] = 'Education / certifications';
    $rows = [];
    foreach ($post as $key => $value) {
        if (in_array($key, ['form_type', 'csrf_token', 'website_address'], true)) continue;
        if ($key === 'roles' && is_array($value)) {
            foreach (array_values($value) as $index => $role) {
                if (!is_array($role)) continue;
                $roleMap = ['category' => 'Trade / category', 'count' => 'Number of workers', 'skillLevel' => 'Required skill level'];
                foreach ($roleMap as $subKey => $label) {
                    if (isset($role[$subKey])) $rows[] = ['Requested role ' . ($index + 1) . ' — ' . $label, bwCleanString($role[$subKey], 1000)];
                }
            }
            continue;
        }
        if (is_array($value)) {
            $value = implode(', ', array_map(static fn($v) => bwCleanString($v, 1000), $value));
        }
        $value = bwCleanString($value, 10000);
        $label = $labels[$key] ?? ucwords(str_replace(['_', '-'], ' ', $key));
        if (str_ends_with($key, 'Consent') || in_array($key, ['jobUpdates','companyInformationAccurate','legalComplianceConsent','dueDiligenceConsent','logoDisplayConsent','employerConsent'], true)) {
            $value = $value !== '' ? 'Yes' : 'No';
        }
        $rows[] = [$label, $value];
    }
    return $rows;
}

function bwSmtpRead($socket, array $expectedCodes): string
{
    $response = '';
    while (($line = fgets($socket, 515)) !== false) {
        $response .= $line;
        if (strlen($line) >= 4 && $line[3] === ' ') break;
    }
    if ($response === '') throw new RuntimeException('SMTP server closed the connection unexpectedly.');
    $code = (int)substr($response, 0, 3);
    if (!in_array($code, $expectedCodes, true)) {
        throw new RuntimeException('SMTP server returned an error (code ' . $code . '). Check the configured SMTP mailbox settings.');
    }
    return $response;
}

function bwSmtpCommand($socket, string $command, array $expectedCodes): string
{
    if (fwrite($socket, $command . "\r\n") === false) throw new RuntimeException('Could not write to the SMTP server.');
    return bwSmtpRead($socket, $expectedCodes);
}

function bwEmailXlsx(array $config, string $xlsxPath, string $xlsxName, string $reference, string $formLabel, string $submitterEmail = ''): void
{
    foreach (['admin_email','from_email','from_name','smtp_host','smtp_port','smtp_encryption','smtp_username','smtp_password'] as $key) {
        if (!isset($config[$key]) || (string)$config[$key] === '') throw new RuntimeException('Email settings are incomplete in private/config.php.');
    }
    if (str_contains((string)$config['smtp_password'], 'CHANGE_THIS')) {
        throw new RuntimeException('SMTP password has not been configured in private/config.php.');
    }
    $host = (string)$config['smtp_host'];
    $port = (int)$config['smtp_port'];
    $encryption = strtolower((string)$config['smtp_encryption']);
    $transport = $encryption === 'ssl' ? 'ssl://' : 'tcp://';
    $context = stream_context_create(['ssl' => ['verify_peer' => true, 'verify_peer_name' => true, 'allow_self_signed' => false]]);
    $socket = @stream_socket_client($transport . $host . ':' . $port, $errno, $errstr, 25, STREAM_CLIENT_CONNECT, $context);
    if (!$socket) throw new RuntimeException('Could not connect to the SMTP server. Check Hostinger SMTP settings and hosting network access.');
    stream_set_timeout($socket, 25);
    try {
        bwSmtpRead($socket, [220]);
        bwSmtpCommand($socket, 'EHLO blueework.com', [250]);
        if ($encryption === 'tls') {
            bwSmtpCommand($socket, 'STARTTLS', [220]);
            $crypto = stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            if ($crypto !== true) throw new RuntimeException('Could not establish encrypted SMTP connection.');
            bwSmtpCommand($socket, 'EHLO blueework.com', [250]);
        }
        bwSmtpCommand($socket, 'AUTH LOGIN', [334]);
        bwSmtpCommand($socket, base64_encode((string)$config['smtp_username']), [334]);
        bwSmtpCommand($socket, base64_encode((string)$config['smtp_password']), [235]);
        bwSmtpCommand($socket, 'MAIL FROM:<' . $config['from_email'] . '>', [250]);
        bwSmtpCommand($socket, 'RCPT TO:<' . $config['admin_email'] . '>', [250, 251]);
        bwSmtpCommand($socket, 'DATA', [354]);

        $boundary = '=_BlueeWork_' . bin2hex(random_bytes(12));
        $subject = 'BlueeWork ' . $formLabel . ' — ' . $reference;
        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $fromName = '=?UTF-8?B?' . base64_encode((string)$config['from_name']) . '?=';
        $headers = 'Date: ' . date(DATE_RFC2822) . "\r\n"
            . 'From: ' . $fromName . ' <' . $config['from_email'] . ">\r\n"
            . 'To: <' . $config['admin_email'] . ">\r\n"
            . 'Subject: ' . $encodedSubject . "\r\n"
            . 'MIME-Version: 1.0' . "\r\n"
            . 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . "\r\n";
        $bodyText = "A new BlueeWork website form was submitted.\n\nForm: {$formLabel}\nReference: {$reference}\nReceived (UTC): " . gmdate('Y-m-d H:i:s') . "\n\nThe Excel attachment contains the submitted form fields and upload filenames. Uploaded CVs, certificates, partner documents and logos are stored separately in private server storage and are not attached to this email.\n";
        if (filter_var($submitterEmail, FILTER_VALIDATE_EMAIL)) $bodyText .= "\nApplicant contact email: {$submitterEmail}\n";
        $fileData = file_get_contents($xlsxPath);
        if ($fileData === false) throw new RuntimeException('Could not read the Excel attachment.');
        $body = '--' . $boundary . "\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: quoted-printable\r\n\r\n"
            . quoted_printable_encode($bodyText) . "\r\n"
            . '--' . $boundary . "\r\n"
            . 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name="' . $xlsxName . "\"\r\n"
            . "Content-Transfer-Encoding: base64\r\n"
            . 'Content-Disposition: attachment; filename="' . $xlsxName . "\"\r\n\r\n"
            . chunk_split(base64_encode($fileData), 76, "\r\n")
            . '--' . $boundary . "--\r\n";
        $message = $headers . "\r\n" . $body;
        $message = preg_replace('/^\./m', '..', $message) ?? $message;
        $message = str_replace(["\r\n", "\r", "\n"], "\n", $message);
        $message = str_replace("\n", "\r\n", $message);
        if (fwrite($socket, $message . ".\r\n") === false) throw new RuntimeException('Could not send the email message.');
        bwSmtpRead($socket, [250]);
        @fwrite($socket, "QUIT\r\n");
    } finally {
        fclose($socket);
    }
}

function bwCleanupDirectory(string $path): void
{
    if (!is_dir($path)) return;
    $items = scandir($path) ?: [];
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $target = $path . '/' . $item;
        if (is_dir($target) && !is_link($target)) bwCleanupDirectory($target);
        else @unlink($target);
    }
    @rmdir($path);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    bwRespond(405, 'Form submission required', 'Please submit one of the BlueeWork website forms.');
}

$contentLength = (int)($_SERVER['CONTENT_LENGTH'] ?? 0);
if ($contentLength > (int)($config['max_request_bytes'] ?? 26214400)) {
    bwRespond(413, 'Submission too large', 'The submitted form and files exceed the size limit. Please reduce the file sizes and try again.');
}
if (!isset($_POST['csrf_token'], $_SESSION['blueework_csrf']) || !hash_equals((string)$_SESSION['blueework_csrf'], (string)$_POST['csrf_token'])) {
    bwRespond(403, 'Session expired', 'Please return to the BlueeWork website, reopen the form, and submit it again.');
}
if (bwCleanString($_POST['website_address'] ?? '') !== '') {
    bwRespond(400, 'Unable to process submission', 'The form could not be processed. Please try again.');
}

$formType = bwCleanString($_POST['form_type'] ?? '', 40);
$formLabels = ['candidate' => 'Candidate Registration', 'company' => 'Company Manpower Requisition', 'partner' => 'Recruitment Partner Application'];
if (!isset($formLabels[$formType])) bwRespond(400, 'Invalid form', 'Please submit a valid BlueeWork registration form.');

$reference = strtoupper(substr($formType, 0, 3)) . '-' . gmdate('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
$uploadDir = $uploadRoot . '/' . $reference;
$storedPaths = [];
$xlsxPath = '';
$uploadRows = [];
try {
    bwEnsureDir($submissionDir);
    bwEnsureDir($uploadRoot);
    bwEnsureDir($logDir);

    $post = $_POST;
    if ($formType === 'candidate') {
        bwRequireFields($post, [
            'name' => 'Full name', 'email' => 'Email address', 'phone' => 'Phone number', 'country' => 'Current country of residence',
            'accuracyConsent' => 'Candidate accuracy declaration', 'privacyConsent' => 'Privacy and job-matching consent',
        ]);
        bwCheckEmail(bwCleanString($post['email']), 'candidate email address');
        $post['jobUpdates'] = $post['jobUpdates'] ?? '';
        bwStoreUploadField('cv', 'CV / résumé', ['pdf','doc','docx'], (int)$config['max_file_bytes'], 1, false, $uploadDir, $storedPaths, $uploadRows);
        bwStoreUploadField('certificates', 'Certificates / qualifications', ['pdf','doc','docx','jpg','jpeg','png'], (int)$config['max_file_bytes'], (int)$config['max_files_per_field'], false, $uploadDir, $storedPaths, $uploadRows);
    } elseif ($formType === 'company') {
        bwRequireFields($post, [
            'company' => 'Company legal name', 'industry' => 'Industry / business sector', 'contact' => 'Contact person',
            'email' => 'Business email', 'phone' => 'Phone number', 'location' => 'Work country / location', 'employerConsent' => 'Employer authorization and contact consent', 'companyPrivacyConsent' => 'Company privacy notice confirmation',
        ]);
        bwCheckEmail(bwCleanString($post['email']), 'business email address');
        $post['visaSupport'] = $post['visaSupport'] ?? '';
        $roles = $post['roles'] ?? [];
        if (!is_array($roles) || count($roles) < 1 || count($roles) > 50) {
            throw new InvalidArgumentException('Please provide between 1 and 50 required worker categories.');
        }
        foreach ($roles as $i => $role) {
            if (!is_array($role) || bwCleanString($role['category'] ?? '') === '' || bwCleanString($role['count'] ?? '') === '' || bwCleanString($role['skillLevel'] ?? '') === '') {
                throw new InvalidArgumentException('Please complete the trade, worker quantity and skill level for each requested role.');
            }
            $count = filter_var($role['count'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 100000]]);
            if ($count === false) throw new InvalidArgumentException('Worker quantities must be whole numbers greater than zero.');
            $post['roles'][$i]['count'] = (string)$count;
        }
    } elseif ($formType === 'partner') {
        bwRequireFields($post, [
            'legalName' => 'Registered company legal name', 'businessType' => 'Business type', 'country' => 'Country of registration',
            'registrationNumber' => 'Company registration number', 'address' => 'Registered business address', 'representative' => 'Authorised representative',
            'role' => 'Representative role', 'email' => 'Business email', 'phone' => 'Business phone', 'licence' => 'Recruitment licence status',
            'sourceCountries' => 'Countries where candidates are sourced', 'trades' => 'Industries and job categories covered', 'owners' => 'Directors / beneficial owners',
            'companyInformationAccurate' => 'Company information declaration', 'legalComplianceConsent' => 'Legal compliance declaration',
            'dueDiligenceConsent' => 'Due diligence consent', 'logoDisplayConsent' => 'Agency logo display permission', 'partnerPrivacyConsent' => 'Partner privacy notice confirmation',
        ]);
        bwCheckEmail(bwCleanString($post['email']), 'partner business email address');
        if (!in_array(bwCleanString($post['licence']), ['Licensed','Not required in my jurisdiction','Pending'], true)) {
            throw new InvalidArgumentException('Please select a valid recruitment licence status.');
        }
        bwStoreUploadField('agencyLogo', 'Agency logo', ['png','jpg','jpeg','webp'], (int)$config['max_logo_bytes'], 1, true, $uploadDir, $storedPaths, $uploadRows);
        bwStoreUploadField('supportingDocuments', 'Supporting documents', ['pdf','doc','docx','jpg','jpeg','png'], (int)$config['max_file_bytes'], (int)$config['max_files_per_field'], false, $uploadDir, $storedPaths, $uploadRows);
    }

    $rows = [
        ['Field', 'Value'],
        ['Submission reference', $reference],
        ['Form type', $formLabels[$formType]],
        ['Submitted at (UTC)', gmdate('Y-m-d H:i:s')],
        ['Processing status', $formType === 'partner' ? 'Submitted — pending BlueeWork review' : 'Submitted — pending BlueeWork review'],
    ];
    $rows = array_merge($rows, bwFlattenFields($post, $formType));
    foreach ($uploadRows as $uploadRow) $rows[] = $uploadRow;
    if ($formType === 'partner') $rows[] = ['Agency logo publication', 'Do not publish until the agency is verified, approved, and the logo-use permission is confirmed.'];

    $xlsxName = 'BlueeWork_' . strtolower($formType) . '_' . gmdate('Ymd_His') . '_' . strtolower(substr($reference, -8)) . '.xlsx';
    $xlsxPath = $submissionDir . '/' . $xlsxName;
    $xlsxBytes = bwCreateXlsx($rows);
    if (file_put_contents($xlsxPath . '.tmp', $xlsxBytes, LOCK_EX) === false) throw new RuntimeException('Could not save the Excel file to private storage.');
    @chmod($xlsxPath . '.tmp', 0640);
    if (!rename($xlsxPath . '.tmp', $xlsxPath)) throw new RuntimeException('Could not finalize the Excel file.');

    try {
        bwEmailXlsx($config, $xlsxPath, $xlsxName, $reference, $formLabels[$formType], bwCleanString($post['email'] ?? ''));
        $emailSent = true;
    } catch (Throwable $mailError) {
        $emailSent = false;
        bwLog('Email delivery failed for ' . $reference . ': ' . $mailError->getMessage(), $logDir);
    }

    // Rotate the form token after a successful save to reduce accidental duplicate posts.
    $_SESSION['blueework_csrf'] = bin2hex(random_bytes(32));
    if ($emailSent) {
        bwRespond(200, 'Thank you — submission received', 'Your form has been saved as an Excel file and the notification has been emailed to the BlueeWork team. If you uploaded documents, they are stored separately in restricted server storage. This submission does not itself guarantee a job, placement, or partner approval.', $reference);
    }
    bwRespond(200, 'Submission saved; email needs attention', 'Your form and Excel file were saved securely, but the email could not be delivered. BlueeWork must check the private server log and SMTP configuration. Please do not submit repeatedly; keep the reference number for follow-up.', $reference);
} catch (InvalidArgumentException $error) {
    bwLog('Validation failed for ' . $reference . ': ' . $error->getMessage(), $logDir);
    if ($uploadDir !== $uploadRoot) bwCleanupDirectory($uploadDir);
    if ($xlsxPath !== '' && is_file($xlsxPath . '.tmp')) @unlink($xlsxPath . '.tmp');
    bwRespond(422, 'Please check your form', $error->getMessage());
} catch (Throwable $error) {
    bwLog('Processing failed for ' . $reference . ': ' . $error->getMessage(), $logDir);
    if (!is_file($xlsxPath) && $uploadDir !== $uploadRoot) bwCleanupDirectory($uploadDir);
    if ($xlsxPath !== '' && is_file($xlsxPath . '.tmp')) @unlink($xlsxPath . '.tmp');
    bwRespond(500, 'We could not finish your submission', 'Please try again later or contact partners@blueework.com. If the problem continues, the BlueeWork administrator should check the private server log.');
}
