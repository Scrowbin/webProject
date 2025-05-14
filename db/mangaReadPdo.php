<?php
    require_once('pdo.php');

    function getPages($chapterID){
        $pages = pdo_query('SELECT *  FROM chapter_pages WHERE ChapterID = ?',$chapterID);
        return $pages;
    }
    
    function getChapterID($mangaSlug, $chapterNumber){
        $sql = 'SELECT ChapterID
                FROM chapter c
                JOIN manga m
                ON c.MangaID = m.MangaID
                WHERE m.Slug = ? AND c.ChapterNumber = ?';
        return pdo_query_value($sql,$mangaSlug,$chapterNumber);
    }

    function getMangaInfo($chapterID){
        $mangaName = pdo_query_one('SELECT MangaNameOG,manga.MangaID,manga.Slug FROM manga JOIN chapter ON manga.MangaID = chapter.MangaID WHERE chapter.ChapterID = ?',$chapterID);
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

    function getNextChapter($chapterID) {
        // Get current chapter info
        $current = pdo_query_one('SELECT ChapterNumber, MangaID FROM chapter WHERE ChapterID = ?', $chapterID);
        if (!$current) return null;
    
        // Find the next chapter
        $next = pdo_query_one(
            'SELECT ChapterNumber FROM chapter 
             WHERE MangaID = ? AND ChapterNumber > ? 
             ORDER BY ChapterNumber ASC LIMIT 1',
            $current['MangaID'], $current['ChapterNumber']
        );
    
        return $next['ChapterNumber'] ?? null;
    }
    
    function getPrevChapter($chapterID) {
        // Get current chapter info
        $current = pdo_query_one('SELECT ChapterNumber, MangaID FROM chapter WHERE ChapterID = ?', $chapterID);
        if (!$current) return null;
    
        // Find the previous chapter
        $prev = pdo_query_one(
            'SELECT ChapterNumber FROM chapter 
             WHERE MangaID = ? AND ChapterNumber < ? 
             ORDER BY ChapterNumber DESC LIMIT 1',
            $current['MangaID'], $current['ChapterNumber']
        );
    
        return $prev['ChapterNumber'] ?? null;
    }

    
    function getCommentSection($chapterID) {
        $sql = 'SELECT cs.CommentSectionID, COUNT(c.CommentID) AS NumOfComments
                FROM commentsection cs
                LEFT JOIN comment c ON cs.CommentSectionID = c.CommentSectionID
                WHERE cs.ChapterID = ?
                GROUP BY cs.CommentSectionID';
        return pdo_query_one($sql, $chapterID);
    }
    
?>