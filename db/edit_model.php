<?php 
    require_once('pdo.php');
    function getMangaInfo($mangaID){
        $mangaInfo= pdo_query_one('select * from manga where mangaID = ?',$mangaID);
        return $mangaInfo;
    }
    function getTags($mangaID){
        $tags = pdo_query('SELECT tag.TagName FROM tag join manga_tag on tag.TagID = manga_tag.TagID where manga_tag.MangaID=?',$mangaID);

        $tagNames = [];
        foreach ($tags as $tag) {
            $tagNames[] = $tag['TagName'];
        }
        return $tagNames;
    }
    
    function getMangaAuthors($mangaID) {
        $authors =pdo_query('SELECT AuthorName FROM author
        JOIN manga_author ON author.AuthorID = manga_author.AuthorID
        WHERE manga_author.mangaID = ?', $mangaID);
        
        foreach ($authors as $author) {
            $authorNames[] = $author['AuthorName'];
        }
        return $authorNames;
    }

    function getMangaArtists($mangaID) {
        $authors = pdo_query('SELECT ArtistName FROM artist
                          JOIN manga_artist ON artist.ArtistID = manga_artist.ArtistID
                          WHERE manga_artist.mangaID = ?', $mangaID);
        foreach ($authors as $author) {
            $authorNames[] = $author['ArtistName'];
        }
        return $authorNames;
    }

    //handle edit
    function artistExist($artistName){
        $sql = "SELECT ArtistID FROM artist where ArtistName = ?";
        $row = pdo_query_value($sql,$artistName);
        // If no row is found, return null instead of false
        if ($row === false) {
            return null;
        }

        return $row;  // Return the result if found
    }
    function authorExist($artistName){
        $sql = "SELECT AuthorID FROM author where AuthorName = ?";
        $row = pdo_query_value($sql,$artistName);
        if ($row === false) {
            return null;
        }

        return $row;  // Return the result if found
    }
    function insertArtist($artistName){
        $sql = "INSERT INTO artist (ArtistName) VALUES (?)";
        return pdo_execute_return_id($sql,$artistName);
    }

    function insertAuthor($authorName){
        $sql = "INSERT INTO author (AuthorName) VALUES (?)";
        return pdo_execute_return_id($sql,$authorName);
    }
    function checkMangaAuthor($authorID, $mangaID) {
        $sql = "SELECT 1 FROM manga_author WHERE AuthorID = ? AND MangaID = ?";
        $result = pdo_query($sql, $authorID, $mangaID);
    
        return !empty($result); // true if there is a row, false if empty
    }
    function checkMangaArtist($artistID, $mangaID) {
        $sql = "SELECT 1 FROM manga_artist WHERE ArtistID = ? AND MangaID = ?";
        $result = pdo_query($sql, $artistID, $mangaID);
    
        return !empty($result); // true if there is a row, false if empty
    }
    function assignAuthorManga($mangaID,$authorID){
        $sql = "INSERT INTO manga_author (MangaID, AuthorID) VALUES (?,?)";
        return pdo_execute($sql,$mangaID,$authorID);
    }
    function assignArtistManga($mangaID,$authorID){
        $sql = "INSERT INTO manga_artist (MangaID, ArtistID) VALUES (?,?)";
        return pdo_execute($sql,$mangaID,$authorID);
    }

    //actual manga editing
    function editMangaNewCover($MangaID, $NameOG, $NameEN, $mangaDesc, $OGLanguage, $coverLink, $demographic, $content_rating, $publication_year, $publication_status) {
        $sql = "UPDATE manga 
                SET MangaNameOG = ?, 
                    MangaNameEN = ?, 
                    MangaDiscription = ?, 
                    OriginalLanguage = ?, 
                    CoverLink = ?, 
                    MagazineDemographic = ?, 
                    ContentRating = ?, 
                    PublicationYear = ?, 
                    PublicationStatus = ?
                WHERE MangaID = ?";
        pdo_execute($sql, $NameOG, $NameEN, $mangaDesc, $OGLanguage, $coverLink, $demographic, $content_rating, $publication_year, $publication_status, $MangaID);
    }
    function editMangaNoNewCover($MangaID, $NameOG, $NameEN, $mangaDesc, $OGLanguage, $demographic, $content_rating, $publication_year, $publication_status) {
        $sql = "UPDATE manga 
                SET MangaNameOG = ?, 
                    MangaNameEN = ?, 
                    MangaDiscription = ?, 
                    OriginalLanguage = ?, 
                    MagazineDemographic = ?, 
                    ContentRating = ?, 
                    PublicationYear = ?, 
                    PublicationStatus = ?
                WHERE MangaID = ?";
        pdo_execute($sql, $NameOG, $NameEN, $mangaDesc, $OGLanguage, $demographic, $content_rating, $publication_year, $publication_status, $MangaID);
    }
    //check tag
    function getTagID($tagName){
        $sql = "SELECT TagID FROM tag WHERE TagName = ?";
        return pdo_query_value($sql,$tagName);
    }
    function checkTag($tagID,$mangaID){
        $sql = "SELECT 1 FROM manga_tag WHERE TagID = ? AND MangaID = ?";
        $result = pdo_query($sql, $tagID, $mangaID);
    
        return !empty($result); // true if there is a row, false if empty
    }
    