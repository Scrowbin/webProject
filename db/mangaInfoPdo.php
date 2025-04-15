<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once('pdo.php');
    $isLoggedIn = isset($_SESSION['userID']);

    function getMangaInfo($mangaID){
        $mangaInfo= pdo_query_one('select * from manga where mangaID = ?',$mangaID);
        return $mangaInfo;
    }
    function getMangaAuthors($mangaID) {
        return pdo_query('SELECT AuthorName FROM author 
                          JOIN manga_author ON author.AuthorID = manga_author.AuthorID 
                          WHERE manga_author.mangaID = ?', $mangaID);
    }
    
    function getMangaArtists($mangaID) {
        return pdo_query('SELECT ArtistName FROM artist 
                          JOIN manga_artist ON artist.ArtistID = manga_artist.ArtistID 
                          WHERE manga_artist.mangaID = ?', $mangaID);
    }
    function getTags($mangaID){
        $tags = pdo_query('SELECT tag.TagName FROM tag join manga_tag on tag.TagID = manga_tag.TagID where manga_tag.MangaID=?',$mangaID);
        
        $tagNames = [];
        foreach ($tags as $tag) {
            $tagNames[] = $tag['TagName'];
        }
        return $tagNames;
    }
    function getChapters($mangaID){
        $chapters = pdo_query('SELECT * FROM chapter Where MangaID =? ORDER BY ChapterNumber DESC',$mangaID);
        return $chapters;
    }
    function getRating($userID,$mangaID){
        $rating = pdo_query_one('SELECT Rating FROM rating where UserID = ? and MangaID = ?',$userID,$mangaID);
        if ($rating==null) return 0;
        return $rating['Rating'];
    }


    function getCommentCountsPerChapter($mangaID){
        return pdo_query(
            '    SELECT 
  cs.CommentSectionID, 
  c.ChapterID, 
  COUNT(cm.CommentID) AS NumOfComments
FROM 
  chapter c
JOIN 
  commentsection cs ON c.ChapterID = cs.ChapterID
LEFT JOIN 
  comment cm ON cm.CommentSectionID = cs.CommentSectionID
WHERE 
  c.MangaID = ?
GROUP BY 
  cs.CommentSectionID, c.ChapterID;',
            $mangaID
        );
    }


    function isBookmarked($mangaID, $userID) {
        $sql = 'SELECT 1 FROM bookmark WHERE MangaID = ? AND UserID = ?';
        $row = pdo_query_one($sql, $mangaID, $userID);
        return !empty($row);
    }
    
?>