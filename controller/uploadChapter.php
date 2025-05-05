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

    if (chapterExist($mangaID, $chapterNum)){
        $msg = "This chapter already exists.";
        $status = "failed";
        header("Location: ../controller/upload_controller.php?MangaID=$mangaID&status=$status&msg=" . urlencode($msg));
        exit();
    }

    // Save chapter
    $chapterID = insertChapter($mangaID, $volume, $chapterScangroup, $username, $chapterName, $chapterNum);
    makeComment($chapterID);
    // Upload directory
    $uploadDir = "../IMG/$mangaID/$chapterNum/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Loop through uploaded files

    $hasError = false;

    foreach ($_FILES['pages']['tmp_name'] as $i => $tmpName) {
        $originalName = $_FILES['pages']['name'][$i];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $newFileName = ($i + 1) . '.' . $ext;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            try {
                insertPage($chapterID, $newFileName, $i + 1);
            } catch (Exception $e) {
                $hasError = true;
            }
        } else {
            $hasError = true;
        }
    }


    $status = $hasError ? 'partial' : 'success';
    $msg = $hasError ? 'Some pages may not have uploaded properly.' : '';

    header("Location: ../controller/upload_controller.php?MangaID=$mangaID&status=$status&msg=" . urlencode($msg));
    exit;
    }
?>  