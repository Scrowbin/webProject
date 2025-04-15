<?php
    require_once('../db/upload_model.php');
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['userID'] ?? 0;
    if ($userID==0){
        if (isset($_SESSION['username']))
            $userID= getUserID($_SESSION['username'])??0;
        else $userID=0;
    }
    if ($userID== 0)
        $username = "Anonymous";
    else{
        $username = getUsername($userID);
    }
    $mangaID = $_POST['MangaID'];
    $volume = $_POST['volume'] ?? null;
    $chapterScangroup = $_POST['scangroup-name'] ?? "Anonymous"; 
    $chapterNum = $_POST['chapter-number'] ?? 0;
    $chapterName = $_POST['chapter-name'] ?? '';

    // Save chapter
    $chapterID = insertChapter($mangaID, $volume, $chapterScangroup, $username, $chapterName, $chapterNum);
    makeComment($chapterID);
    // Upload directory
    $uploadDir = "../IMG/$mangaID/$chapterNum/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Loop through uploaded files

    foreach ($_FILES['pages']['tmp_name'] as $i => $tmpName) {
        $originalName = $_FILES['pages']['name'][$i];
    
        // Get file extension
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $ext = strtolower($ext); // ensure lowercase
    
        // Define new name like 1.png, 2.jpg, etc.
        $newFileName = ($i + 1) . '.' . $ext;
        $targetPath = $uploadDir . $newFileName;
    
        if (move_uploaded_file($tmpName, $targetPath)) {
            // Insert with clean filename and page number
            insertPage($chapterID, $newFileName, $i + 1);
        }
    }

    if (isset($_POST['upload_another'])) {
        header("Location: upload_controller.php?MangaID=$mangaID");
    } else {
        header("Location: mangaInfo_controller.php?MangaID=$mangaID");
    }
    exit;
}
?>  