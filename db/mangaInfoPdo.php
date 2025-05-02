<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once('pdo.php');
    $isLoggedIn = isset($_SESSION['userID']);
    function getUserID ($username){
        $userID = pdo_query_one('SELECT user.UserID FROM account join user on
        account.username = user.Username where account.username = ?', $username);
        if ($userID===null || $userID==='' || $userID === false) return null;
        return $userID['UserID'];
    }

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

    function getAllManga($limit = null, $offset = 0) {
        $sql = 'SELECT * FROM manga ORDER BY MangaID';
        if ($limit !== null) {
            $sql .= ' LIMIT ' . intval($offset) . ', ' . intval($limit);
        }
        return pdo_query($sql);
    }

    function getLatestUpdatedManga($limit = 10) {
        // Hardcoded limit to avoid SQL errors
        $sql = 'SELECT * FROM manga ORDER BY MangaID LIMIT ' . intval($limit);
        return pdo_query($sql);
    }

    function getPopularManga($limit = 4) {
        // Hardcoded limit to avoid SQL errors
        $sql = 'SELECT * FROM manga ORDER BY MangaID LIMIT ' . intval($limit);
        return pdo_query($sql);
    }

    function getAverageRating($mangaID){
        $sql = 'SELECT AVG(Rating) FROM rating WHERE MangaID = ?';
        return pdo_query_value($sql,$mangaID);
    }
    function getTotalFollows($mangaID){
        $sql = 'SELECT COUNT(*) FROM bookmark WHERE MangaID = ?';
        return pdo_query_value($sql,$mangaID);
    }
    function getTotalComments($mangaID){
        $sql = 'SELECT COUNT(*) FROM commentsection cs 
                JOIN chapter c ON cs.ChapterID = c.ChapterID
                JOIN comment co ON cs.CommentSectionID = co.CommentSectionID
                WHERE MangaID = ?';
        return pdo_query_value($sql,$mangaID);
    }
?>