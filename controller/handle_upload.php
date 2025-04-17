<?php
require_once "your_pdo_connection_file.php"; // replace with your actual PDO config

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1: Collect and validate fields
    $name_original = trim($_POST["original_name"]);
    $name_english = trim($_POST["english_name"]);
    $authors = trim($_POST["authors"]);
    $artists = trim($_POST["artists"]);
    $demographic = $_POST["demographic"];
    $content_rating = $_POST["content_rating"];
    $publication_year = intval($_POST["year"]);
    $publication_status = $_POST["status"];
    $tags = $_POST["tags"] ?? [];

    // Basic field validation
    if (
        empty($name_original) || empty($name_english) || empty($authors) ||
        empty($artists) || empty($demographic) || empty($content_rating) ||
        empty($publication_year) || empty($publication_status)
    ) {
        die("Please fill in all required fields.");
    }

    // Step 2: Insert basic manga info (without cover image path yet)
    $stmt = $pdo->prepare("INSERT INTO manga (
        NameOriginal, NameEnglish, Authors, Artists,
        Demographic, ContentRating, PublicationYear, PublicationStatus
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $name_original, $name_english, $authors, $artists,
        $demographic, $content_rating, $publication_year, $publication_status
    ]);

    // Step 3: Get the auto-incremented ID
    $mangaID = $pdo->lastInsertId();

    // Step 4: Upload cover image
    $targetDir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($imageFileType, $allowedTypes)) {
        die("Invalid image format.");
    }

    $coverPath = $targetDir . "cover_" . $mangaID . "." . $imageFileType;

    if (getimagesize($_FILES["cover"]["tmp_name"]) === false) {
        die("Uploaded file is not an image.");
    }

    if ($_FILES["cover"]["size"] > 2 * 1024 * 1024) {
        die("Image too large (max 2MB).");
    }

    if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $coverPath)) {
        die("Failed to move uploaded file.");
    }

    // Step 5: Update manga row with the cover path
    $stmt = $pdo->prepare("UPDATE manga SET CoverImage = ? WHERE MangaID = ?");
    $stmt->execute([$coverPath, $mangaID]);

    // Step 6: Insert tags (assuming you have a manga_tag table)
    $tagStmt = $pdo->prepare("INSERT INTO manga_tag (MangaID, TagID) VALUES (?, ?)");
    foreach ($tags as $tagID) {
        $tagStmt->execute([$mangaID, $tagID]);
    }

    echo "Manga uploaded successfully with ID: $mangaID";
}
?>
