<?php
    require_once('pdo.php');

    function getMangaDetails($commentsID){
        $sql = 'SELECT m.MangaID, m.MangaNameOG, m.MangaNameEN, m.CoverLink from manga m JOIN chapter c ON
        m.MangaID = c.MangaID JOIN commentsection cs ON cs.ChapterID = c.ChapterID WHERE
        CommentSectionID = ?';
        $mangaInfo = pdo_query_one($sql,$commentsID);
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

    
    function getComments($commentSectionID,$limit,$offset){
        $sql = 'SELECT 
                    u.Username, 
                    u.Avatar, 
                    c.CommentID, 
                    c.CommentText,  
                    c.ReplyID, 
                    c.CreatedAt,
                    r.CommentText AS QuoteContent,
                    ru.Username AS QuoteUsername
                FROM comment c
                JOIN user u ON c.UserID = u.UserID
                LEFT JOIN comment r ON c.ReplyID = r.CommentID
                LEFT JOIN user ru ON r.UserID = ru.UserID
                WHERE c.CommentSectionID = ?
                ORDER BY c.CreatedAt ASC
                LIMIT ? OFFSET ?';
        $comments = pdo_query_int($sql,$commentSectionID,$limit,$offset);
        
        return $comments;
    }

    function getCount($commentSectionID){
        return pdo_query_one(
            'SELECT Count(*) as total FROM comment WHERE CommentSectionID = ?',
            $commentSectionID
        )['total'];

    }

    function addComment($commentSectionID, $comment,$userID,$replyID){
        $sql = 'INSERT INTO comment (CommentSectionID,CommentText,UserID,ReplyID) VALUES (?,?,?,?)' ;
        pdo_execute($sql,$commentSectionID,$comment,$userID,$replyID);

    }

    function getChapterID($commentSectionID){
        $sql = 'SELECT c.ChapterID,c.ChapterName,c.ChapterNumber FROM chapter c JOIN commentsection cs ON c.ChapterID = cs.ChapterID where cs.CommentSectionID = ?';
        return pdo_query_one($sql,$commentSectionID);
    }
?>