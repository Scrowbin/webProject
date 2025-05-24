<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Global SMTP connection for reuse
$GLOBALS['smtp_connection'] = null;

/**
 * Get or create a reusable SMTP connection
 *
 * @return PHPMailer|null
 */
function get_smtp_connection(): ?PHPMailer
{
    if ($GLOBALS['smtp_connection'] === null) {
        $mail = new PHPMailer(true);
        configure_smtp_settings($mail);
        $GLOBALS['smtp_connection'] = $mail;
    }
    return $GLOBALS['smtp_connection'];
}

/**
 * Close the SMTP connection
 *
 * @return void
 */
function close_smtp_connection(): void
{
    if ($GLOBALS['smtp_connection'] !== null) {
        try {
            $GLOBALS['smtp_connection']->smtpClose();
        } catch (Exception $e) {
            error_log("Error closing SMTP connection: " . $e->getMessage());
        }
        $GLOBALS['smtp_connection'] = null;
    }
}

/**
 * Configure common SMTP settings for PHPMailer
 *
 * @param PHPMailer $mail The PHPMailer instance to configure
 * @return void
 */
function configure_smtp_settings(PHPMailer $mail): void
{
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'snouzen951@gmail.com';
    $mail->Password = 'tmsh kyew warv hndj'; // App password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Performance optimizations
    $mail->Timeout = 15; // Reduce timeout from default 300 seconds to 15 seconds
    $mail->SMTPKeepAlive = true; // Keep connection alive for multiple emails
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
            'stream_context_create' => array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                )
            )
        )
    );

    // Enable debug mode for troubleshooting (set to 0 for production)
    $mail->SMTPDebug = 1; // 0 = off, 1 = client messages, 2 = client and server messages
    $mail->Debugoutput = 'error_log'; // Send debug output to error log

    // Additional performance settings
    $mail->SMTPAutoTLS = false; // Disable automatic TLS encryption
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use explicit STARTTLS

    // Recipients
    $mail->setFrom('snouzen951@gmail.com', 'MangaDax');
}

/**
 * Sends an account activation email to the user.
 *
 * @param string $to_email The recipient's email address
 * @param string $to_name The recipient's name
 * @param string $activation_link The activation link
 * @return bool True if email was sent successfully, false otherwise
 */
function send_activation_email(string $to_email, string $to_name, string $activation_link): bool
{
    error_log("Starting activation email process for: $to_email");
    $start_time = microtime(true);

    // Get reusable SMTP connection
    $mail = get_smtp_connection();
    if (!$mail) {
        error_log("Failed to get SMTP connection for activation email");
        return false;
    }

    try {
        error_log("Configuring email for activation...");

        // Clear any previous recipients
        $mail->clearAddresses();
        $mail->clearAttachments();
        $mail->clearCustomHeaders();

        $mail->addAddress($to_email, $to_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Activate Your MangaDax Account';

        // Email body
        $mail->Body = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Activate Your MangaDax Account</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .logo {
                    max-width: 150px;
                    height: auto;
                }
                .content {
                    background-color: #f9f9f9;
                    padding: 20px;
                    border-radius: 5px;
                }
                .button {
                    display: inline-block;
                    background-color: #FF7F2A;
                    color: white;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 25px;
                    margin: 20px 0;
                    font-weight: bold;
                    font-size: 16px;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: #777;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>MangaDax</h1>
            </div>
            <div class="content">
                <h2>Welcome to MangaDax, $to_name!</h2>
                <p>Thank you for registering with MangaDax. To activate your account and start exploring our manga collection, please click the button below:</p>
                <p style="text-align: center;">
                    <a href="$activation_link" class="button">Active my account</a>
                </p>
                <p>If the button doesn't work, you can also copy and paste the following link into your browser:</p>
                <p style="word-break: break-all;">$activation_link</p>
                <p>This link will expire in 24 hours for security reasons.</p>
            </div>
            <div class="footer">
                <p>This email was sent to $to_email because you registered for an account on MangaDax.</p>
                <p>If you did not register for an account, please ignore this email.</p>
            </div>
        </body>
        </html>
        HTML;

        // Plain text version for non-HTML mail clients
        $mail->AltBody = "Welcome to MangaDax, $to_name!\n\n"
            . "Thank you for registering with MangaDax. To activate your account, please visit the following link:\n\n"
            . "$activation_link\n\n"
            . "This link will expire in 24 hours for security reasons.\n\n"
            . "If you did not register for an account, please ignore this email.";

        // Send the email
        error_log("Attempting to send activation email...");
        $mail->send();

        $end_time = microtime(true);
        $duration = round(($end_time - $start_time) * 1000, 2);
        error_log("Activation email sent successfully in {$duration}ms to: $to_email");

        return true;
    } catch (Exception $e) {
        $end_time = microtime(true);
        $duration = round(($end_time - $start_time) * 1000, 2);
        error_log("Activation email sending failed after {$duration}ms: " . $mail->ErrorInfo . " | Exception: " . $e->getMessage());
        return false;
    }
}

/**
 * Sends a password reset email to the user.
 *
 * @param string $to_email The recipient's email address
 * @param string $to_name The recipient's name
 * @param string $reset_link The password reset link
 * @return bool True if email was sent successfully, false otherwise
 */
function send_password_reset_email(string $to_email, string $to_name, string $reset_link): bool
{
    error_log("Starting password reset email process for: $to_email");
    $start_time = microtime(true);

    // Get reusable SMTP connection
    $mail = get_smtp_connection();
    if (!$mail) {
        error_log("Failed to get SMTP connection for password reset email");
        return false;
    }

    try {
        error_log("Configuring email for password reset...");

        // Clear any previous recipients
        $mail->clearAddresses();
        $mail->clearAttachments();
        $mail->clearCustomHeaders();

        $mail->addAddress($to_email, $to_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your MangaDax Password';

        // Email body
        $mail->Body = <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Your MangaDax Password</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .logo {
                    max-width: 150px;
                    height: auto;
                }
                .content {
                    background-color: #f9f9f9;
                    padding: 20px;
                    border-radius: 5px;
                }
                .button {
                    display: inline-block;
                    background-color: #FF7F2A;
                    color: white;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 25px;
                    margin: 20px 0;
                    font-weight: bold;
                    font-size: 16px;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: #777;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>MangaDax</h1>
            </div>
            <div class="content">
                <h2>Password Reset Request</h2>
                <p>We received a request to reset your password for your MangaDax account. To reset your password, please click the button below:</p>
                <p style="text-align: center;">
                    <a href="$reset_link" class="button">Reset my password</a>
                </p>
                <p>If the button doesn't work, you can also copy and paste the following link into your browser:</p>
                <p style="word-break: break-all;">$reset_link</p>
                <p>This link will expire in 1 hour for security reasons.</p>
                <p>If you did not request a password reset, please ignore this email and your password will remain unchanged.</p>
            </div>
            <div class="footer">
                <p>This email was sent to $to_email because a password reset was requested for your MangaDax account.</p>
                <p>If you did not request this, please ignore this email.</p>
            </div>
        </body>
        </html>
        HTML;

        // Plain text version for non-HTML mail clients
        $mail->AltBody = "Password Reset Request for MangaDax\n\n"
            . "We received a request to reset your password for your MangaDax account. To reset your password, please visit the following link:\n\n"
            . "$reset_link\n\n"
            . "This link will expire in 1 hour for security reasons.\n\n"
            . "If you did not request a password reset, please ignore this email and your password will remain unchanged.";

        // Send the email
        error_log("Attempting to send password reset email...");
        $mail->send();

        $end_time = microtime(true);
        $duration = round(($end_time - $start_time) * 1000, 2);
        error_log("Password reset email sent successfully in {$duration}ms to: $to_email");

        return true;
    } catch (Exception $e) {
        $end_time = microtime(true);
        $duration = round(($end_time - $start_time) * 1000, 2);
        error_log("Password reset email sending failed after {$duration}ms: " . $mail->ErrorInfo . " | Exception: " . $e->getMessage());
        return false;
    }
}
