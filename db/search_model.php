<?php
require_once('pdo.php');

/**
 * Search for manga by name, author, or tags
 *
 * @param string $query The search query
 * @param int $limit Maximum number of results to return
 * @return array Array of manga matching the search criteria
 */
function searchManga($query, $limit = 10) {
    // Sanitize the query
    $query = trim($query);
    $containsTerm = '%' . $query . '%';
    $startsTerm = $query . '%';

    // Search in manga names with priority for Japanese names (MangaNameOG)
    $sql = "SELECT DISTINCT m.*,
                  (SELECT COUNT(*) FROM rating WHERE MangaID = m.MangaID) as RatingCount,
                  (SELECT AVG(CAST(Rating AS DECIMAL(3,2))) FROM rating WHERE MangaID = m.MangaID) as AvgRating,
                  (SELECT COUNT(*) FROM bookmark WHERE MangaID = m.MangaID) as BookmarkCount,
                  CASE
                      WHEN LOWER(m.MangaNameOG) LIKE LOWER(?) THEN 1  -- Starts with (Japanese)
                      WHEN LOWER(m.MangaNameEN) LIKE LOWER(?) THEN 2  -- Starts with (English)
                      WHEN LOWER(m.MangaNameOG) LIKE LOWER(?) THEN 3  -- Contains (Japanese)
                      WHEN LOWER(m.MangaNameEN) LIKE LOWER(?) THEN 4  -- Contains (English)
                      WHEN LOWER(a.AuthorName) LIKE LOWER(?) THEN 5   -- Author
                      WHEN LOWER(art.ArtistName) LIKE LOWER(?) THEN 6 -- Artist
                      WHEN LOWER(t.TagName) LIKE LOWER(?) THEN 7      -- Tag
                      ELSE 8
                  END as MatchPriority
           FROM manga m
           LEFT JOIN manga_author ma ON m.MangaID = ma.MangaID
           LEFT JOIN author a ON ma.AuthorID = a.AuthorID
           LEFT JOIN manga_artist mart ON m.MangaID = mart.MangaID
           LEFT JOIN artist art ON mart.ArtistID = art.ArtistID
           LEFT JOIN manga_tag mt ON m.MangaID = mt.MangaID
           LEFT JOIN tag t ON mt.TagID = t.TagID
           WHERE LOWER(m.MangaNameOG) LIKE LOWER(?)  -- Starts with (Japanese)
              OR LOWER(m.MangaNameEN) LIKE LOWER(?)  -- Starts with (English)
              OR LOWER(m.MangaNameOG) LIKE LOWER(?)  -- Contains (Japanese)
              OR LOWER(m.MangaNameEN) LIKE LOWER(?)  -- Contains (English)
              OR LOWER(a.AuthorName) LIKE LOWER(?)   -- Author
              OR LOWER(art.ArtistName) LIKE LOWER(?) -- Artist
              OR LOWER(t.TagName) LIKE LOWER(?)      -- Tag
           GROUP BY m.MangaID
           ORDER BY MatchPriority ASC
           LIMIT ?";

    return pdo_query_int($sql,
        $startsTerm, $startsTerm,     // Starts with (Japanese, English)
        $containsTerm, $containsTerm, // Contains (Japanese, English)
        $containsTerm, $containsTerm, $containsTerm, // Author, Artist, Tag
        $startsTerm, $startsTerm,     // WHERE Starts with (Japanese, English)
        $containsTerm, $containsTerm, // WHERE Contains (Japanese, English)
        $containsTerm, $containsTerm, $containsTerm, // WHERE Author, Artist, Tag
        $limit
    );
}

/**
 * Get the status of a manga (Completed or Ongoing)
 *
 * @param string $status The publication status from the database
 * @return string Simplified status (Completed or Ongoing)
 */
function getSimplifiedStatus($status) {
    if ($status === 'Completed') {
        return 'Completed';
    } else {
        return 'Ongoing';
    }
}
?>
