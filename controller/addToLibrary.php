<?php
session_start();
header('Content-Type: application/json');

require_once('../db/LibraryAndRating.php');

if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$userID = $_SESSION['userID'];
$mangaID = $_POST['mangaID'] ?? null;

if (!$mangaID) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Missing mangaID"]);
    exit;
}

$isBookmarked = isBookmarked($mangaID, $userID);

if ($isBookmarked) {
    removeBookmark($mangaID, $userID);
    echo json_encode(["success" => true, "bookmarked" => false]);
} else {
    addToLibrary($mangaID, $userID);
    echo json_encode(["success" => true, "bookmarked" => true]);
}
exit;
?>
