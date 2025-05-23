<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once 'pdo.php';
    $isLoggedIn = isset($_SESSION['userID']);
   
    function getMangaIDFromSlug($slug){
        $sql = 'SELECT MangaID from manga WHERE Slug = ?';
        return pdo_query_value($sql,$slug);
    }
    function getMangaInfo($mangaID){
        $sql = 'CALL GetMangaDetails(?)';
        $mangaInfo = pdo_query_one($sql, $mangaID);
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
        $sql = 'CALL GetChaptersWithCommentCount(?)';
        $chapters = pdo_query($sql, $mangaID);
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

    function getFirstChapter($mangaID) {
        $sql = 'SELECT ChapterID FROM chapter
                WHERE MangaID = ?
                ORDER BY ChapterNumber ASC
                LIMIT 1';
        return pdo_query_one($sql, $mangaID);
    }

    function getCommentSectionID($chapterID) {
        $sql = 'SELECT CommentSectionID FROM commentsection WHERE ChapterID = ?';
        $result = pdo_query_one($sql, $chapterID);
        return $result ? $result['CommentSectionID'] : null;
    }

    /**
     * Get manga with the highest average ratings
     *
     * @param int $limit Number of manga to return
     * @param int $minRatings Minimum number of ratings required for a manga to be included
     * @return array Array of manga with their average ratings
     */
    function getTopRatedManga($limit = 4, $minRatings = 3) {
        $sql = 'SELECT m.*, AVG(r.Rating) as AvgRating, COUNT(r.Rating) as RatingCount
                FROM manga m
                JOIN rating r ON m.MangaID = r.MangaID
                GROUP BY m.MangaID
                HAVING COUNT(r.Rating) >= ?
                ORDER BY AVG(r.Rating) DESC, RatingCount DESC
                LIMIT ?';

        return pdo_query_int($sql, $minRatings, $limit);
    }
    function getRandomManga() {
    $sql = "SELECT Slug FROM manga ORDER BY RAND() LIMIT 1";
    return pdo_query_value($sql);
}