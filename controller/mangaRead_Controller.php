<?php
    require_once('../db/mangaReadPdo.php');
    $chapterID = $_GET['chapterID'] ?? null;
    if (!$chapterID) {
        $chapterID = '1';
    }
    
    $pages = getPages($chapterID);
    if (!$pages) {
        die("chapter not found.");
    }

    

    $chapters = getChapters($chapterID);
    $mangaInfo = getMangaInfo($chapterID);
    $chapterInfo = getChapterInfo($chapterID);
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