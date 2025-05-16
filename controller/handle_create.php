<?php
require_once "../db/create_model.php";
header('Content-Type: application/json');



function extractArtists($input) {
    $artists = array_map('trim', explode(',', $input));
    return array_filter($artists); // Removes empty strings
}

$response = [];
function containsJapanese(string $text): bool {
    return preg_match('/[\p{Hiragana}\p{Katakana}\p{Han}]/u', $text) === 1;
}
function createSlug(string $title): string {
    // Convert to lowercase
    $slug = mb_strtolower($title, 'UTF-8');

    // Remove apostrophes (e.g., "JoJo's" → "Jojos")
    $slug = str_replace("'", '', $slug);

    // Replace any non-letter/digit (including spaces, dashes, etc.) with a hyphen
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);

    // Trim leading and trailing hyphens
    $slug = trim($slug, '-');

    return $slug;
}
try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    // Step 1: Collect and validate fields
    $name_original = trim($_POST["original_name"] ?? '');
    $name_english = trim($_POST["english_name"] ?? '');
    $authors = extractArtists($_POST["authors"] ?? '');
    $artists = extractArtists($_POST["artists"] ?? '');
    $mangaDesc = trim($_POST['description'] ?? '');
    $original_language = $_POST["language"] ?? '';
    $demographic = $_POST["demographic"] ?? '';
    $content_rating = $_POST["content_rating"] ?? '';
    $publication_year = intval($_POST["year"] ?? 0);
    $publication_status = $_POST["status"] ?? '';
    $tags = $_POST["tags"] ?? [];
    $slugSource = containsJapanese($name_original) ? $name_english : $name_original;
    $slug = createSlug($slugSource);
    if (
        empty($name_original) || empty($name_english) || empty($authors) ||
        empty($artists) || empty($demographic) || empty($content_rating) ||
        empty($publication_year) || empty($publication_status) || empty($mangaDesc)
    ) {
        throw new Exception("Please fill in all required fields.");
    }

    // Step 2:Check if manga already exist, Get manga ID and prepare authors/artists
    if (mangaExist($name_english,$name_original)){
        throw new Exception("This manga already exists.");
    }

    $mangaID = getLatestID() + 1;
    $authorsID = [];
    $artistsID = [];

    foreach ($authors as $a) {
        error_log("Checking author: $a");
        $authorsID[] = authorExist($a) ?: insertAuthor($a);
    }

    foreach ($artists as $a) {
        error_log("Checking artist: $a");
        $artistsID[] = artistExist($a) ?: insertArtist($a);
    }

    // Step 3: Handle image upload
    $targetDir = "../IMG/" . $mangaID . "/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageFileType = strtolower(pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($imageFileType, $allowedTypes)) {
        throw new Exception("Invalid image format.");
    }

    $coverLink = "m" . $mangaID . "." . $imageFileType;
    $coverPath = $targetDir . $coverLink;

    if (getimagesize($_FILES["cover"]["tmp_name"]) === false) {
        throw new Exception("Uploaded file is not a valid image.");
    }

    if ($_FILES["cover"]["size"] > 10 * 1024 * 1024) {
        throw new Exception("Image too large (max 10MB).");
    }

    if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $coverPath)) {
        throw new Exception("Failed to move uploaded file.");
    }

    // Step 4: Insert manga
    insertManga( $mangaID,$name_original, $name_english, $mangaDesc,$original_language, $coverLink,$demographic, $content_rating, $publication_year, $publication_status,$slug);
    error_log("Step 4: Manga inserted.");

    // Step 5: Link authors and artists
    foreach ($authorsID as $aID) {
        assignAuthorManga($mangaID, $aID);
    }

    foreach ($artistsID as $aID) {
        assignArtistManga($mangaID, $aID);
    }

    // Step 6: Link tags
    foreach ($tags as $tag) {
        $tagID = getTagID($tag);
        mapMangaWithTag($mangaID, $tagID);
    }

    $response = [
        'success' => true,
        'message' => "Manga uploaded successfully with ID: $mangaID",
        'mangaID' => $mangaID
    ];

} catch (Exception $e) {
    http_response_code(400); // Bad request
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];

    error_log("Upload failed: " . $e->getMessage());
}

echo json_encode($response);
error_log("Final JSON response: " . json_encode($response));
?>
