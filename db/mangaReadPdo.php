<?php
    require_once('pdo.php');

    function getPages($chapterID){
        $pages = pdo_query('SELECT *  FROM chapter_pages WHERE ChapterID = ?',$chapterID);
        return $pages;
    }
   
    function getMangaInfo($chapterID){
        $mangaName = pdo_query_one('SELECT MangaNameOG,manga.MangaID FROM manga JOIN chapter ON manga.MangaID = chapter.MangaID WHERE chapter.ChapterID = ?',$chapterID);
        return $mangaName ?? null; // return null if not found
    }

    function getChapterInfo($chapterID){
        $info =pdo_query_one('SELECT * FROM chapter WHERE chapterID = ?',$chapterID);
        return $info ?? null;
    }
    function getChapters($chapterID){
        $rawMangaID = pdo_query_one('SELECT MangaID FROM chapter WHERE ChapterID = ?',$chapterID);
        if (!$rawMangaID) return [];

        $mangaID = $rawMangaID['MangaID']; 
        $chapters = pdo_query('SELECT * from chapter WHERE MangaID = ? ORDER BY ChapterNumber DESC',$mangaID);
        return $chapters;
    }

    function hasUserRatedManga($userID,$mangaID){
        return pdo_query_one(
            'SELECT Rating FROM rating WHERE UserID = ? AND MangaID = ?',
            $userID,
            $mangaID
        ) !== null;
    }
?>