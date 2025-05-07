<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
require_once('../db/report_model.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['userID'] ?? 0;
    $chapterID = $_POST['chapterID'] ?? 0;
    // If user is not logged in, return an error
    if ($userID === 0) {
        http_response_code(403); // Forbidden
        echo json_encode(["success" => false, "message" => "You must be logged in to report."]);
        exit;
    }

    if ($chapterID === 0) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing mangaID"]);
        exit;
    }
    
    $type = $_POST['reason'];
    $description = $_POST['details'];

    try {
        sendChapterReport($userID, $chapterID, $type, $description);
        echo json_encode(["success" => true, "message" => "Successfully reported"]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
        exit;
    }
}

