<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../db/mangaReadPdo.php');
    require_once('../db/account_db.php');
    $mangaSlug = $_GET['slug'];
    $chapterNumber = str_replace('-', '.', $_GET['chapter']);
    $chapterID = getChapterID($mangaSlug,$chapterNumber) ?? null;
    
    
    if (!$chapterID) {
        die('chapterID not found');
    }

    $pages = getPages($chapterID);
    if (!$pages) {
        die("chapter not found.");
    }

    $userID = $_SESSION['userID'] ?? 0;
    $username = $_SESSION['username'] ?? null;
    $role = get_role($userID)??"user";
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