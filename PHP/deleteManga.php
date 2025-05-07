<?php
$success = $_GET['success'] ?? '1';
$message = $_GET['message'] ?? ($success === '1' ? 'Manga deleted successfully.' : 'An error occurred during deletion.');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Manga Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="alert <?= $success === '1' ? 'alert-success' : 'alert-danger' ?> shadow-sm" role="alert">
            <h4 class="alert-heading"><?= $success === '1' ? 'Success!' : 'Error!' ?></h4>
            <p><?= htmlspecialchars($message) ?></p>
            <hr>
            <a href="/admin/manga_list.php" class="btn btn-outline-primary">Back to Manga List</a>
        </div>
    </div>
</body>
</html>