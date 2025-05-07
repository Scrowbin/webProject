<?php
require_once('pdo.php');
require_once('delete_model.php');
function mangaExist($mangaID):bool{
    $sql = "SELECT 1 FROM manga WHERE MangaID = ?";
    $result = pdo_query($sql,$mangaID);
    return !empty($result); // true if there is a row, false if empty
}

function getChapters($mangaID){
    $sql = "SELECT ChapterID FROM chapter WHERE MangaID = ?";
    $result = pdo_query($sql,$mangaID);
    return $result;
}

function unmapAuthor($mangaID){
    $sql = "DELETE FROM manga_author WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}

function unmapArtist($mangaID){
    $sql = "DELETE FROM manga_artist WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}
function unmapTag($mangaID){
    $sql = "DELETE FROM manga_tag WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}
function deleteManga($mangaID){
    $sql = "DELETE FROM manga WHERE MangaID = ?";
    pdo_execute($sql,$mangaID);
}