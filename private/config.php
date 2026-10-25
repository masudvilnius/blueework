<?php
/**
 * BlueeWork private configuration.
 * Keep this file OUTSIDE public_html. Set the SMTP password before launch.
 */
return [
    'admin_email' => 'masud@gmail.com',
    'from_email' => 'forms@blueework.com',
    'from_name' => 'BlueeWork Website',
    'smtp_host' => 'smtp.hostinger.com',
    'smtp_port' => 587,
    'smtp_encryption' => 'tls', // STARTTLS on port 587; use 'ssl' with port 465 if preferred.
    'smtp_username' => 'forms@blueework.com',
    'smtp_password' => 'CHANGE_THIS_TO_THE_FORMS_MAILBOX_PASSWORD',
    'max_request_bytes' => 25 * 1024 * 1024, // Includes multipart overhead.
    'max_file_bytes' => 10 * 1024 * 1024,
    'max_logo_bytes' => 2 * 1024 * 1024,
    'max_files_per_field' => 10,
];
