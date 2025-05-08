<?php
    require_once('helper.php');
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
   
    <style>
        .page-btn {
    margin: 0 5px;
    padding: 5px 10px;
    cursor: pointer;
}

.page-btn.active {
    background-color: #007bff;
    color: white;
    border: none;
}
    </style>
    <div class="container-xxl pt-5 mt-4" id="manga-container">

    </div>

    <div id="pagination" class="pagination-controls mt-4 text-center"></div>

    <!-- <div class="d-flex justify-content-center mt-4">
   
    </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>
    <script src="../JS/reading_history.js"></script>
</body>
</html>
