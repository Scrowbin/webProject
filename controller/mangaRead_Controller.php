<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once('../db/mangaReadPdo.php');
    require_once('../db/account_db.php');
    $chapterID = $_GET['chapterID'] ?? null;
    if (!$chapterID) {
        die('chapterID not found');
    }
    
    $pages = getPages($chapterID);
    if (!$pages) {
        die("chapter not found.");
    }

    $userID = $_SESSION['userID'] ?? null;
    $username = $_SESSION['username'] ?? null;
    if (!isset($_SESSION['userID'])) {
        if ($username != null){
            $userID = getUserID($_SESSION['username']);
            $_SESSION['userID'] = $userID;        
        }
        else $userID=0;
    }
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