<?php
    require_once('../db/mangaReadPdo.php');
    $chapterID = $_GET['chapterID'] ?? null;
    if (!$chapterID) {
        die('chapterID not found');
    }
    
    $pages = getPages($chapterID);
    if (!$pages) {
        die("chapter not found.");
    }

    
    $nextChapterID = getNextChapter($chapterID);
    $prevChapterID = getPrevChapter($chapterID);

    $chapters = getChapters($chapterID);
    $mangaInfo = getMangaInfo($chapterID);
    $chapterInfo = getChapterInfo($chapterID);
    $commentSection = getCommentSection($chapterID);
    $pageValues = [];
    $pageLinks = [];
    $i = 1;
    foreach($pages as $page){
        $pageValues[] = $i;
        $pageLinks[] = $page['PageLink'];
        $i++;
    }


    
    
?>

<?php include('../PHP/mangaRead.php')?>