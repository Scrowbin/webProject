<?php
    require_once('pdo.php');
    
    function getMangaInfo($mangaID){
        $mangaInfo= pdo_query_one('select * from manga where mangaID = ?',$mangaID);
        return $mangaInfo;
    }
    function getAuthorsArtists($mangaID) {
        $mangaAuthor = pdo_query('SELECT AuthorName FROM author JOIN manga_author ON author.AuthorID = manga_author.AuthorID WHERE manga_author.mangaID = ?', $mangaID);
        $mangaArtist = pdo_query('SELECT ArtistName FROM artist JOIN manga_artist ON artist.ArtistID = manga_artist.ArtistID WHERE manga_artist.mangaID = ?', $mangaID);
    
        $authorNames = [];
        foreach ($mangaAuthor as $row) {
            $authorNames[] = $row['AuthorName'];
        }
    
        $artistNames = [];
        foreach ($mangaArtist as $row) {
            $artistNames[] = $row['ArtistName'];
        }
    
        $authors = implode(', ', $authorNames);
        $artists = implode(', ', $artistNames);
    
        return $authors . ($authors && $artists ? ' | ' : '') . $artists;
    }

    function getTags($mangaID){
        $tags = pdo_query('SELECT tag.TagName FROM tag join manga_tag on tag.TagID = manga_tag.TagID where manga_tag.MangaID=?',$mangaID);
        
        $tagNames = [];
        foreach ($tags as $tag) {
            $tagNames[] = $tag['TagName'];
        }
        return $tagNames;
    }
?>