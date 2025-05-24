<?php
// Test script to compare email sending performance
require_once __DIR__ . '/utils/mail_utils.php';

echo "<h1>Email Performance Test</h1>";

// Test activation email
echo "<h2>Testing Activation Email</h2>";
$start = microtime(true);
$result1 = send_activation_email('test@example.com', 'Test User', 'http://example.com/activate/test');
$end = microtime(true);
$duration1 = round(($end - $start) * 1000, 2);
echo "Activation email result: " . ($result1 ? 'SUCCESS' : 'FAILED') . " in {$duration1}ms<br>";

// Wait a moment
sleep(1);

// Test password reset email
echo "<h2>Testing Password Reset Email</h2>";
$start = microtime(true);
$result2 = send_password_reset_email('test@example.com', 'Test User', 'http://example.com/reset/test');
$end = microtime(true);
$duration2 = round(($end - $start) * 1000, 2);
echo "Password reset email result: " . ($result2 ? 'SUCCESS' : 'FAILED') . " in {$duration2}ms<br>";

echo "<h2>Performance Comparison</h2>";
echo "Activation email: {$duration1}ms<br>";
echo "Password reset email: {$duration2}ms<br>";
echo "Difference: " . abs($duration2 - $duration1) . "ms<br>";

// Close SMTP connection
close_smtp_connection();

echo "<h2>Check Error Log</h2>";
echo "Check your PHP error log for detailed timing information.";
?>
