<?php
    session_start();

    if (!isset($_SESSION['userID'])) {
        // Handle not logged in
        http_response_code(401);
        exit("You must be logged in to rate.");
    }

    $userID = $_SESSION['userID'];  // Use session, not POST
    $mangaID = $_POST['mangaID'] ?? null;
    $rating = $_POST['rating'] ?? null;


?>