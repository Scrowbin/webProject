<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

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
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'snouzen951@gmail.com';
        $mail->Password = 'tmsh kyew warv hndj'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('snouzen951@gmail.com', 'MangaDax');
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
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
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
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'snouzen951@gmail.com';
        $mail->Password = 'tmsh kyew warv hndj'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('snouzen951@gmail.com', 'MangaDax');
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
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Password reset email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}
