<?php
    require_once 'helper.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reading History - MangaDax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="../CSS/navbar.css">
    <link rel="stylesheet" href = "../CSS/latestUpdates.css">

</head>
<body>
    <?php include('includes/navbar.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div class="page-wrapper">
        <style>
            
            .page-btn {
                margin: 0 5px;
                padding: 8px 13px;
                cursor: pointer;
                border-radius: 5px;
            }

            .page-btn.active {
                background-color: #FF6740;
                color: white;
                border: none;
            }
        </style>

        <div class="container-xxl pt-5 mt-4" id="manga-container">
            <!-- Content will be loaded by JavaScript -->
        </div>

    <div id="pagination" class="pagination-controls mt-4 text-center mb-5"></div>
    </div> <!-- Close page-wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>
    <script src="../JS/reading_history.js"></script>
</body>
</html>
