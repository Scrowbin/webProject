<?php
    require("../db/edit_model.php");
    header('Content-Type: application/json');


    function extractArtists($input) {
        $artists = array_map('trim', explode(',', $input));
        return array_filter($artists); // Removes empty strings
    }
    try {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            throw new Exception("Invalid request method.");
        }
    
        // Step 1: Collect and validate fields
        $mangaID = $_POST["manga_id"] ?? "";
        if ($mangaID === ""){
            $response = [
                'success' => false,
                'error' => "No MangaId"
            ];
            echo json_encode($response);
            return;
        }

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
    
        if (
            empty($name_original) || empty($name_english) || empty($authors) ||
            empty($artists) || empty($demographic) || empty($content_rating) ||
            empty($publication_year) || empty($publication_status) || empty($mangaDesc)
        ) {
            throw new Exception("Please fill in all required fields.");
        }
    
        //step 2: check and assign artist authors with manga
        foreach ($authors as $a) {
            $authorID = authorExist($a) ?: insertAuthor($a);
            checkMangaAuthor($authorID,$mangaID)?:assignAuthorManga($mangaID,$authorID);
        }
    
        foreach ($artists as $a) {
            $artistID = artistExist($a) ?: insertArtist($a);
            checkMangaArtist($artistID,$mangaID)?:assignArtistManga($mangaID,$authorID);
        }
    
    
        // Step 3: Handle image upload
        $targetDir = "../IMG/" . $mangaID . "/";
        $newCover = false;
        if (isset($_FILES["cover"]) && $_FILES["cover"]["error"] !== UPLOAD_ERR_NO_FILE) {
            $newCover = true;
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
        
            if ($_FILES["cover"]["size"] > 2 * 1024 * 1024) {
                throw new Exception("Image too large (max 2MB).");
            }
        
            if (!move_uploaded_file($_FILES["cover"]["tmp_name"], $coverPath)) {
                throw new Exception("Failed to move uploaded file.");
            }
        }
    
    
        // Step 4: Edit manga
        if ($newCover)
            editMangaNewCover($mangaID,$name_original, $name_english, $mangaDesc,$original_language, $coverLink,$demographic, $content_rating, $publication_year, $publication_status);
        else
            editMangaNoNewCover($mangaID,$name_original, $name_english, $mangaDesc,$original_language,$demographic, $content_rating, $publication_year, $publication_status);
            
        // Step 6: Link tags if not already
        foreach ($tags as $tag) {
            $tagID = getTagID($tag);
            if (!checkTag($tagID,$mangaID)){
                mapMangaWithTag($mangaID, $tagID);
            }
            
        }
    
        $response = [
            'success' => true,
            'message' => "Manga edited successfully with ID: $mangaID",
            'mangaID' => $mangaID
        ];
    
    } catch (Exception $e) {
        http_response_code(400); // Bad request
        $response = [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
    
    echo json_encode($response);
    ?>
    