<?php
// This script will reset the auto-increment value for the manga table
require_once('db/delete_manga_model.php');
require_once('db/pdo.php');

// Force reset to 6 (or whatever value you need)
$result = forceResetAutoIncrement(6);

if ($result) {
    echo "Auto-increment value has been reset to 6 successfully!";
} else {
    echo "Failed to reset auto-increment value. Check error logs for details.";
}

// Also update the handle_delete_manga.php to use the new function
echo "<br><br>Now, when you delete a manga, the auto-increment will be properly reset.";
echo "<br><br><a href='index.php'>Return to homepage</a>";
?>
