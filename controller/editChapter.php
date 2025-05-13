<?php
    require_once('../db/editChapter.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    function cleanNumber($n) {
        return (is_numeric($n) && floor($n) == $n) ? intval($n) : floatval($n);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $chapterID = $_POST['chapterID'];
        $volume = $_POST['volume'] ?? null;
        $chapterScangroup = $_POST['scangroup-name'] ?? "Anonymous"; 
        $chapterNum = cleanNumber($_POST['chapter-number']) ?? 0;
        $chapterName = $_POST['chapter-name'] ?? '';
        $language = $_POST['language'] ?? 'en';

        if (!ChapterExist($chapterID)){
            $msg = "This chapter doesnt exist.";
            $status = "failed";
            header("Location: ../controller/editChapter_controller.php?ChapterID=$chapterID&status=$status&msg=" . urlencode($msg));
            exit();
        }

        // Save chapter
        editInfo($chapterID, $volume, $chapterScangroup, $chapterName, $chapterNum,$language);
        
        // Upload directory
        if (empty($_FILES['pages']['name']) || count(array_filter($_FILES['pages']['name'])) === 0) {
            $msg = "Edited.";
            $status = "success";
            header("Location: ../controller/editChapter_controller.php?ChapterID=$chapterID&status=$status&msg=" . urlencode($msg));
            exit();
        }

        $mangaID = getMangaID($chapterID);
        $uploadDir = "../IMG/$mangaID/$chapterNum/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Loop through uploaded files

        $hasError = false;
        deleteOldPages($chapterID);

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

        header("Location: ../controller/editChapter_controller.php?ChapterID=$chapterID&status=$status&msg=" . urlencode($msg));
        exit;
    }
?>  