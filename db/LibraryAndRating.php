<?php
    require_once('pdo.php');
    function getUserID ($username){
        $userID = pdo_query_one('SELECT user.UserID FROM account join user on
        account.username = user.Username where account.username = ?', $username);
        if ($userID===null or $userID==='') return null;
        return $userID['UserID'];
    }

    function addToLibrary($mangaID,$userID){
        $sql = 'INSERT INTO bookmark (MangaID, UserID) VALUES (?,?);';
        pdo_execute($sql,$mangaID,$userID);
        
    }
    function removeBookmark($mangaID, $userID){
        $sql = 'DELETE FROM bookmark WHERE MangaID = ? AND UserID = ?';
        pdo_execute($sql,$mangaID,$userID);
    }

    function isBookmarked($mangaID, $userID) {
        $sql = 'SELECT 1 FROM bookmark WHERE MangaID = ? AND UserID = ?';
        $row = pdo_query_one($sql, $mangaID, $userID);
        return !empty($row);
    }

    function getRating($userID,$mangaID){
        $rating = pdo_query_one('SELECT Rating FROM rating where UserID = ? and MangaID = ?',$userID,$mangaID);
        if ($rating==null) return 0;
        return $rating['Rating'];
    }

    function removeRating($userID,$mangaID){
        $sql = 'DELETE FROM rating where UserID = ? and MangaID = ?';
        pdo_execute($sql,$userID,$mangaID);
    }
    function addRating($userID,$mangaID,$rating){
        $sql = 'INSERT INTO `rating` (`UserID`, `MangaID`, `Rating`) VALUES (?, ?, ?)';
        pdo_execute($sql,$userID,$mangaID,$rating);
    }
    function alterRating($userID,$mangaID,$rating){
        $sql = 'UPDATE `rating` SET `Rating` = ? WHERE `UserID` = ? AND `MangaID` = ?';
        pdo_execute($sql, $rating, $userID, $mangaID);
    }

?>