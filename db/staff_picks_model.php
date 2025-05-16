<?php
require_once 'pdo.php';
require_once 'mangaInfoPdo.php';

/**
 * Add a manga to staff picks
 * 
 * @param int $mangaID The manga ID to add to staff picks
 * @param int $userID The admin user ID who added this manga
 * @param string $note Optional note about why this manga was selected
 * @return bool Success status
 */
function addStaffPick($mangaID, $userID, $note = '') {
    // First check if this manga is already in staff picks
    if (isStaffPick($mangaID)) {
        return false;
    }
    
    $sql = "INSERT INTO staff_picks (MangaID, AdminID, Note, AddedDate) 
            VALUES (?, ?, ?, NOW())";
    return pdo_execute($sql, $mangaID, $userID, $note);
}

/**
 * Remove a manga from staff picks
 * 
 * @param int $mangaID The manga ID to remove from staff picks
 * @return bool Success status
 */
function removeStaffPick($mangaID) {
    $sql = "DELETE FROM staff_picks WHERE MangaID = ?";
    return pdo_execute($sql, $mangaID);
}

/**
 * Check if a manga is already in staff picks
 * 
 * @param int $mangaID The manga ID to check
 * @return bool True if manga is in staff picks, false otherwise
 */
function isStaffPick($mangaID) {
    $sql = "SELECT 1 FROM staff_picks WHERE MangaID = ?";
    $result = pdo_query_one($sql, $mangaID);
    return !empty($result);
}

/**
 * Get all staff picks with manga details
 * 
 * @param int $limit Optional limit on number of results
 * @param int $offset Optional offset for pagination
 * @return array Array of staff picks with manga details
 */
function getStaffPicks($limit = null, $offset = 0) {
    $sql = "SELECT sp.*, m.MangaNameOG, m.MangaNameEN, m.CoverLink, m.Slug, m.MangaDiscription, m.OriginalLanguage,
                   u.Username as AdminName
            FROM staff_picks sp
            JOIN manga m ON sp.MangaID = m.MangaID
            JOIN user u ON sp.AdminID = u.UserID
            ORDER BY sp.AddedDate DESC";
    
    if ($limit !== null) {
        $sql .= " LIMIT " . intval($offset) . ", " . intval($limit);
    }
    
    $staffPicks = pdo_query($sql);
    
    // Add additional manga information
    foreach ($staffPicks as $key => $manga) {
        $mangaID = $manga['MangaID'];
        $staffPicks[$key]['tags'] = getTags($mangaID);
        $staffPicks[$key]['authors'] = getMangaAuthors($mangaID);
        $staffPicks[$key]['artists'] = getMangaArtists($mangaID);
        $staffPicks[$key]['AvgRating'] = getAverageRating($mangaID);
        $staffPicks[$key]['RatingCount'] = getRatingCount($mangaID);
    }
    
    return $staffPicks;
}

/**
 * Get the count of ratings for a manga
 * 
 * @param int $mangaID The manga ID
 * @return int Number of ratings
 */
function getRatingCount($mangaID) {
    $sql = "SELECT COUNT(*) FROM rating WHERE MangaID = ?";
    return pdo_query_value($sql, $mangaID);
}

/**
 * Create the staff_picks table if it doesn't exist
 * This is a helper function for initial setup
 * 
 * @return bool Success status
 */
function createStaffPicksTable() {
    $sql = "CREATE TABLE IF NOT EXISTS staff_picks (
        PickID INT(11) NOT NULL AUTO_INCREMENT,
        MangaID INT(11) NOT NULL,
        AdminID INT(11) NOT NULL,
        Note TEXT,
        AddedDate DATETIME NOT NULL,
        PRIMARY KEY (PickID),
        UNIQUE KEY (MangaID),
        FOREIGN KEY (MangaID) REFERENCES manga(MangaID) ON DELETE CASCADE,
        FOREIGN KEY (AdminID) REFERENCES user(UserID) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin";
    
    return pdo_execute($sql);
}
