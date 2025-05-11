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
 * Get all tags from the database
 *
 * @return array Array of all tags
 */
function getAllTags() {
    $sql = 'SELECT * FROM tag ORDER BY TagGroup, TagName';
    return pdo_query($sql);
}

/**
 * Get all authors from the database
 *
 * @return array Array of all authors
 */
function getAllAuthors() {
    $sql = 'SELECT * FROM author ORDER BY AuthorName';
    return pdo_query($sql);
}

/**
 * Get all artists from the database
 *
 * @return array Array of all artists
 */
function getAllArtists() {
    $sql = 'SELECT * FROM artist ORDER BY ArtistName';
    return pdo_query($sql);
}

/**
 * Advanced search for manga based on various filters
 *
 * @param string $query Search query
 * @param string $sortBy Sort order
 * @param string $contentRating Content rating filter
 * @param string $demographic Demographic filter
 * @param string $originalLanguage Original language filter
 * @param string $publicationStatus Publication status filter
 * @param string $publicationYear Publication year filter
 * @param array $includeTags Tags to include
 * @param array $excludeTags Tags to exclude
 * @param string $authorID Author ID filter
 * @param string $artistID Artist ID filter
 * @param int $limit Number of results to return
 * @param int $offset Offset for pagination
 * @return array Array of manga matching the filters
 */
function advancedSearchManga(
    $query = '',
    $sortBy = 'none',
    $contentRating = 'any',
    $demographic = 'any',
    $originalLanguage = 'any',
    $publicationStatus = 'any',
    $publicationYear = '',
    $includeTags = [],
    $excludeTags = [],
    $authorID = 'any',
    $artistID = 'any',
    $limit = 12,
    $offset = 0
) {
    // Debug: Log the input parameters
    error_log("Advanced Search Input: " .
        "query=$query, " .
        "sortBy=$sortBy, " .
        "contentRating=$contentRating, " .
        "demographic=$demographic, " .
        "originalLanguage=$originalLanguage, " .
        "publicationStatus=$publicationStatus, " .
        "publicationYear=$publicationYear, " .
        "includeTags=" . implode(',', $includeTags) . ", " .
        "excludeTags=" . implode(',', $excludeTags) . ", " .
        "authorID=$authorID, " .
        "artistID=$artistID, " .
        "limit=$limit, " .
        "offset=$offset");

    // Simplified approach - build a basic query first
    $sql = "SELECT DISTINCT m.* FROM manga m";
    $whereConditions = [];
    $params = [];

    // Add necessary joins based on filters
    if ($authorID !== 'any') {
        $sql .= " LEFT JOIN manga_author ma ON m.MangaID = ma.MangaID";
    }

    if ($artistID !== 'any') {
        $sql .= " LEFT JOIN manga_artist mart ON m.MangaID = mart.MangaID";
    }

    // Add search query condition
    if (!empty($query)) {
        $searchParam = '%' . $query . '%';
        $whereConditions[] = "(m.MangaNameOG LIKE ? OR m.MangaNameEN LIKE ? OR m.MangaDiscription LIKE ?)";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }

    // Add other filter conditions
    if ($contentRating !== 'any') {
        $whereConditions[] = "m.ContentRating = ?";
        $params[] = $contentRating;
    }

    if ($demographic !== 'any') {
        $whereConditions[] = "m.MagazineDemographic = ?";
        $params[] = $demographic;
    }

    if ($originalLanguage !== 'any') {
        $whereConditions[] = "m.OriginalLanguage = ?";
        $params[] = $originalLanguage;
    }

    if ($publicationStatus !== 'any') {
        $whereConditions[] = "m.PublicationStatus = ?";
        $params[] = $publicationStatus;
    }

    if (!empty($publicationYear)) {
        $whereConditions[] = "m.PublicationYear = ?";
        $params[] = $publicationYear;
    }

    if ($authorID !== 'any') {
        $whereConditions[] = "ma.AuthorID = ?";
        $params[] = $authorID;
    }

    if ($artistID !== 'any') {
        $whereConditions[] = "mart.ArtistID = ?";
        $params[] = $artistID;
    }

    // Handle tag filtering
    if (!empty($includeTags) || !empty($excludeTags)) {
        // Debug
        error_log("Processing tags - Include: " . implode(', ', $includeTags) . " | Exclude: " . implode(', ', $excludeTags));

        // We'll handle tags separately to avoid complex subqueries
        $mangaIDs = getAllMangaIDs();
        error_log("Total manga IDs before filtering: " . count($mangaIDs));

        // Handle include tags - manga must have ALL of these tags
        if (!empty($includeTags)) {
            // Get manga IDs for each tag separately
            foreach ($includeTags as $tag) {
                $tagMangaIDs = getMangaIDsWithTags([$tag]);
                // Manga must have ALL include tags
                $mangaIDs = array_intersect($mangaIDs, $tagMangaIDs);
                error_log("After including tag '$tag': " . count($mangaIDs) . " manga remaining");
            }
        }

        // Handle exclude tags - manga must have NONE of these tags
        if (!empty($excludeTags)) {
            // Get all manga IDs that have any of the exclude tags
            $excludeMangaIDs = getMangaIDsWithTags($excludeTags);
            // Remove all manga that have any exclude tag
            $mangaIDs = array_diff($mangaIDs, $excludeMangaIDs);
            error_log("After excluding tags: " . count($mangaIDs) . " manga remaining");
        }

        if (!empty($mangaIDs)) {
            $placeholders = implode(',', array_fill(0, count($mangaIDs), '?'));
            $whereConditions[] = "m.MangaID IN ($placeholders)";
            $params = array_merge($params, $mangaIDs);
            error_log("Added " . count($mangaIDs) . " manga IDs to query");
        } else {
            // If no manga match the tag filters, return empty result
            error_log("No manga match the tag filters, returning empty result");
            return [];
        }
    }

    // Add WHERE clause if there are conditions
    if (!empty($whereConditions)) {
        $sql .= " WHERE " . implode(" AND ", $whereConditions);
    }

    // Add ORDER BY clause
    switch ($sortBy) {
        case 'latest_update':
            $sql .= " ORDER BY m.MangaID DESC";
            break;
        case 'oldest_update':
            $sql .= " ORDER BY m.MangaID ASC";
            break;
        case 'title_asc':
            $sql .= " ORDER BY m.MangaNameOG ASC";
            break;
        case 'title_desc':
            $sql .= " ORDER BY m.MangaNameOG DESC";
            break;
        case 'highest_rating':
            // For rating-based sorting, we need to join with the rating table
            $sql = "SELECT m.*, IFNULL(AVG(r.Rating), 0) as AvgRating
                   FROM manga m
                   LEFT JOIN rating r ON m.MangaID = r.MangaID";

            // Re-add necessary joins
            if ($authorID !== 'any') {
                $sql .= " LEFT JOIN manga_author ma ON m.MangaID = ma.MangaID";
            }

            if ($artistID !== 'any') {
                $sql .= " LEFT JOIN manga_artist mart ON m.MangaID = mart.MangaID";
            }

            // Re-add WHERE clause
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(" AND ", $whereConditions);
            }

            $sql .= " GROUP BY m.MangaID ORDER BY AvgRating DESC, m.MangaID DESC";
            break;
        case 'lowest_rating':
            // For rating-based sorting, we need to join with the rating table
            $sql = "SELECT m.*, IFNULL(AVG(r.Rating), 0) as AvgRating
                   FROM manga m
                   LEFT JOIN rating r ON m.MangaID = r.MangaID";

            // Re-add necessary joins
            if ($authorID !== 'any') {
                $sql .= " LEFT JOIN manga_author ma ON m.MangaID = ma.MangaID";
            }

            if ($artistID !== 'any') {
                $sql .= " LEFT JOIN manga_artist mart ON m.MangaID = mart.MangaID";
            }

            // Re-add WHERE clause
            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(" AND ", $whereConditions);
            }

            $sql .= " GROUP BY m.MangaID ORDER BY AvgRating ASC, m.MangaID DESC";
            break;
        case 'best_match':
            if (!empty($query)) {
                $sql .= " ORDER BY
                         CASE
                             WHEN m.MangaNameOG LIKE ? THEN 1
                             WHEN m.MangaNameEN LIKE ? THEN 2
                             ELSE 3
                         END,
                         m.MangaID DESC";
                $exactMatchParam = $query . '%';
                $params[] = $exactMatchParam;
                $params[] = $exactMatchParam;
            } else {
                $sql .= " ORDER BY m.MangaID DESC";
            }
            break;
        default:
            $sql .= " ORDER BY m.MangaID DESC";
            break;
    }

    // Add LIMIT clause
    $sql .= " LIMIT " . (int)$offset . ", " . (int)$limit;

    // Debug: Log the SQL query and parameters
    error_log("Advanced Search SQL: " . $sql);
    error_log("Advanced Search Params: " . print_r($params, true));

    try {
        // Execute the query
        $conn = pdo_get_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debug: Log the result count
        error_log("Advanced Search Result Count: " . count($result));

        return $result;
    } catch (PDOException $e) {
        error_log("Advanced Search Error: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all manga IDs from the database
 *
 * @return array Array of all manga IDs
 */
function getAllMangaIDs() {
    $sql = "SELECT MangaID FROM manga";
    $result = pdo_query($sql);
    return array_column($result, 'MangaID');
}

/**
 * Get manga IDs that have the specified tags
 *
 * @param array $tagNames Array of tag names
 * @return array Array of manga IDs
 */
function getMangaIDsWithTags($tagNames) {
    if (empty($tagNames)) {
        return [];
    }

    // Debug
    error_log("Getting manga IDs with tags: " . implode(', ', $tagNames));

    // If we're looking for a single tag
    if (count($tagNames) === 1) {
        $sql = "SELECT DISTINCT mt.MangaID
                FROM manga_tag mt
                JOIN tag t ON mt.TagID = t.TagID
                WHERE t.TagName = ?";

        $result = pdo_query($sql, $tagNames[0]);
    } else {
        // For multiple tags, we need to be more careful
        $placeholders = implode(',', array_fill(0, count($tagNames), '?'));
        $sql = "SELECT DISTINCT mt.MangaID
                FROM manga_tag mt
                JOIN tag t ON mt.TagID = t.TagID
                WHERE t.TagName IN ($placeholders)";

        $result = pdo_query($sql, ...$tagNames);
    }

    $mangaIDs = array_column($result, 'MangaID');

    // Debug
    error_log("Found " . count($mangaIDs) . " manga with tags: " . implode(', ', $tagNames));

    return $mangaIDs;
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

/**
 * Simple test function to get all manga
 *
 * @param int $limit Number of manga to return
 * @return array Array of all manga
 */
function getAllMangaTest($limit = 10) {
    $sql = 'SELECT * FROM manga LIMIT ' . (int)$limit;
    return pdo_query($sql);
}
