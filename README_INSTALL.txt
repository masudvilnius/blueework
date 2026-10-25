BLUEEWORK HOSTINGER FORM PACKAGE
================================

What this package does
----------------------
* Serves the homepage at https://blueework.com/ from index.php (no .html in the public URL).
* Connects the Candidate, Company/Employer and Partner Agency onboarding forms to submit.php.
* Validates required form fields, file types and file sizes, and verifies a session CSRF token.
* Creates a separate Excel .xlsx workbook for every successful submission.
* Stores each workbook outside public_html in private/storage/submissions/.
* Stores candidate CVs/certificates and partner logo/supporting documents outside public_html in private/storage/uploads/.
* Emails the Excel workbook to masud@gmail.com using authenticated SMTP.
* Emails only the Excel workbook, not CVs or identity/KYC documents. The workbook records the filenames; uploaded files stay in private storage.
* Partner logos are NOT automatically published. They must be reviewed and approved before being displayed on the public website.

IMPORTANT: It will not send email until you set a real SMTP mailbox password in private/config.php.

PACKAGE LAYOUT
--------------
blueework_hostinger_package/
  public_html/
    index.php
    submit.php
    .htaccess
  private/
    config.php
    storage/
      submissions/
      uploads/
      logs/

The private/ folder MUST be beside public_html, not inside it. Example expected path:
  /domains/blueework.com/public_html/index.php
  /domains/blueework.com/public_html/submit.php
  /domains/blueework.com/private/config.php
  /domains/blueework.com/private/storage/

HOSTINGER INSTALLATION
----------------------
1. Make a backup of the current public_html folder before changing anything.
2. In Hostinger hPanel, open Websites > Manage > File Manager.
3. Extract this package on your computer first if that is easier.
4. Copy the CONTENTS of package/public_html/ into your website's public_html/ folder. Keep the supplied index.php and submit.php there. Merge the supplied .htaccess with an existing one instead of blindly deleting rules you already need.
5. Copy the package/private/ folder so it sits NEXT TO public_html/ (for example domains/blueework.com/private/). Do NOT place it at public_html/private/.
6. Ensure the PHP account can write to private/storage/submissions/, private/storage/uploads/ and private/storage/logs/. Start with restricted permissions (normally 750/755 as appropriate for your hosting account); do not use 777. The private folder should not be accessible through a public URL.
7. In Hostinger hPanel, create an email mailbox such as forms@blueework.com (or choose another mailbox on your domain). Verify the mailbox works before configuring the form.
8. Edit private/config.php and replace CHANGE_THIS_TO_THE_FORMS_MAILBOX_PASSWORD with that mailbox's password. Do not use your Hostinger account password unless it is also the mailbox password. Keep the recipient set to masud@gmail.com unless you intentionally want to change it.
9. Hostinger's usual SMTP settings for Hostinger Email are smtp.hostinger.com, port 587 with TLS/STARTTLS (or port 465 with SSL). Confirm the actual settings shown in Hostinger hPanel > Emails > Manage > Connect Apps & Devices for your mailbox. Set smtp_encryption='tls' with port 587, or 'ssl' with port 465.
10. Set PHP 8.2+ in Hostinger PHP Configuration. The PHP extensions fileinfo, session, openssl and zlib are required. The workbook is generated as a real .xlsx using PHP zlib; no Composer installation is required.
11. Recommended PHP limits: post_max_size at least 30M, upload_max_filesize at least 12M, max_file_uploads at least 25, and max_execution_time at least 120 seconds (if your plan allows these settings).
12. Confirm SSL is active for blueework.com. Use the HTTPS URL to test forms.
13. Test each form with dummy/non-sensitive data first. Check that a reference number appears, that a .xlsx workbook is created under private/storage/submissions/, and that the email arrives at masud@gmail.com. Check Spam/Junk too. Then test candidate uploads and partner logo/supporting documents with harmless sample files.
14. After deploying index.php, the homepage remains https://blueework.com/ with no .php suffix. The form handler is a backend endpoint and is not a page intended for navigation.

MAIL CONFIGURATION
------------------
Default in private/config.php:
  admin_email = masud@gmail.com
  from_email / smtp_username = forms@blueework.com
  smtp_host = smtp.hostinger.com
  smtp_port = 587
  smtp_encryption = tls

The FROM address should match a real mailbox authenticated to the SMTP server. If you use a different Hostinger email address, update both from_email and smtp_username to that address. The email will contain one Excel .xlsx attachment per submission.

WHERE DATA IS STORED
--------------------
* Each form submission: private/storage/submissions/BlueeWork_<type>_<timestamp>_<reference>.xlsx
* Uploaded CVs, certificates, agency logos and supporting documents: private/storage/uploads/<reference>/ (randomized filenames)
* Minimal operational/error log: private/storage/logs/submission-events.log

This is file-based storage, not a database. The XLSX workbooks and uploaded documents contain personal and potentially confidential information; restrict access, back them up securely, and define retention/deletion rules before launch. The email contains candidate/employer/agency form data in Excel, so secure the receiving mailbox and avoid forwarding the files unnecessarily. Uploaded CVs/certificates/agency documents themselves are not attached to the email.

NOTES / LIMITATIONS
-------------------
* An Excel file is created for each submission; submissions are not merged into a single cumulative workbook.
* The public page does not provide an admin dashboard. This package stores partner logos privately; an authorised admin process is still needed to review a partner and publish its logo.
* SMTP delivery depends on correct mailbox credentials and DNS/email authentication. If email fails, the submission workbook remains stored and the website shows its reference number plus an email warning. Check private/storage/logs/submission-events.log (keep this folder private).
* This package is implementation code, not a legal compliance certification. Publish the approved privacy notice and terms, and validate GDPR, recruitment/work-placement and AI compliance before accepting real user data.
