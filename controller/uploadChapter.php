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

    var_dump($mangaID,$volume,$chapterScangroup,$chapterNum,$chapterName);
    // Save chapter
    $chapterID = insertChapter($mangaID, $volume, $chapterScangroup, $username, $chapterName, $chapterNum);

    // Upload directory
    $uploadDir = "../IMG/$mangaID/$chapterID/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Sort files by filename
    $files = [];
    foreach ($_FILES['pages']['name'] as $i => $name) {
        $files[] = [
            'name' => $name,
            'tmp_name' => $_FILES['pages']['tmp_name'][$i],
        ];
    }

    usort($files, fn($a, $b) => strcmp($a['name'], $b['name']));

    foreach ($files as $i => $file) {
        $targetPath = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            insertPage($chapterID, $targetPath, $i + 1);
        }
    }

    if (isset($_POST['upload_another'])) {
        header("Location: ../views/upload_chapter_form.php?manga_id=$mangaID");
    } else {
        header("Location: ../views/manga_detail.php?id=$mangaID");
    }
    exit;
}
?>  