<?php
require_once 'pdo.php';

/**
 * Create a new announcement
 *
 * @param string $content The HTML content of the announcement
 * @param string|null $expireAt The expiration date (can be null for no expiration)
 * @return int The ID of the newly created announcement
 */
function createAnnouncement($content, $expireAt = null) {
    $sql = "INSERT INTO announcement (content, expirteAt, isActive) VALUES (?, ?, 1)";
    return pdo_execute_return_id($sql, $content, $expireAt);
}

/**
 * Get all announcements
 *
 * @param bool $activeOnly Whether to return only active announcements
 * @return array Array of announcements
 */
function getAllAnnouncements($activeOnly = false) {
    $sql = "SELECT * FROM announcement";
    if ($activeOnly) {
        $sql .= " WHERE isActive = 1";
        $sql .= " AND (expirteAt IS NULL OR expirteAt > NOW())";
    }
    $sql .= " ORDER BY announcementID DESC";
    return pdo_query($sql);
}

/**
 * Get a specific announcement by ID
 *
 * @param int $id The announcement ID
 * @return array|null The announcement data or null if not found
 */
function getAnnouncementById($id) {
    $sql = "SELECT * FROM announcement WHERE announcementID = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Update an announcement
 *
 * @param int $id The announcement ID
 * @param string $content The HTML content of the announcement
 * @param string|null $expireAt The expiration date (can be null for no expiration)
 * @param bool $isActive Whether the announcement is active
 * @return bool Success status
 */
function updateAnnouncement($id, $content, $expireAt = null, $isActive = true) {
    $sql = "UPDATE announcement SET content = ?, expirteAt = ?, isActive = ? WHERE announcementID = ?";
    return pdo_execute($sql, $content, $expireAt, $isActive ? 1 : 0, $id);
}

/**
 * Delete an announcement
 *
 * @param int $id The announcement ID
 * @return bool Success status
 */
function deleteAnnouncement($id) {
    $sql = "DELETE FROM announcement WHERE announcementID = ?";
    return pdo_execute($sql, $id);
}

/**
 * Get the latest active announcement
 *
 * @return array|null The announcement data or null if none found
 */
function getLatestActiveAnnouncement() {
    $sql = "SELECT * FROM announcement
            WHERE isActive = 1
            AND (expirteAt IS NULL OR expirteAt > NOW())
            ORDER BY announcementID DESC
            LIMIT 1";
    return pdo_query_one($sql);
}

/**
 * Deactivate all announcements
 *
 * @return bool Success status
 */
function deactivateAllAnnouncements() {
    $sql = "UPDATE announcement SET isActive = 0";
    return pdo_execute($sql);
}
?>
