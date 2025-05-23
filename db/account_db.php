<?php
require_once __DIR__ . '/pdo.php';

/**
 * Checks if a username already exists.
 */
function account_check_username_exists(string $username): bool
{
    $sql = "SELECT username FROM account WHERE username = ? LIMIT 1";
    return pdo_query_one($sql, $username) !== false;
}

/**
 * Checks if an email already exists.
 */
function account_check_email_exists(string $email): bool
{
    $sql = "SELECT email FROM account WHERE email = ? LIMIT 1";
    return pdo_query_one($sql, $email) !== false;
}

/**
 * Adds a new account.
 */
function account_add(string $username, string $hashed_password, string $email, string $activation_token): bool
{
    $insert_sql = "INSERT INTO account (username, password, email, activated, activate_token)
                   VALUES (?, ?, ?, 0, ?)";
    try {
        pdo_execute($insert_sql, $username, $hashed_password, $email, $activation_token);
        return true;
    } catch (PDOException $e) {
        error_log("Account Add Failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Adds a corresponding user record after account creation.
 */
function user_add(string $username): bool
{
    // UserID auto-increments. Avatar has a default value in the schema.
    $sql = "INSERT INTO user (Username, Joined)
            VALUES (?, NOW())";
    try {
        pdo_execute($sql, $username);
        return true;
    } catch (PDOException $e) {
        error_log("User Add Failed for Username {$username}: " . $e->getMessage());
        return false;
    }
}

/**
 * Finds account details by activation token.
 */
function account_find_by_token(string $token): array|false
{
    $sql = "SELECT username, activated FROM account WHERE activate_token = ?";
    return pdo_query_one($sql, $token);
}

/**
 * Activates an account using its token.
 */
function account_activate(string $token): bool
{
    $account = account_find_by_token($token);
    if ($account && !$account['activated']) {
        $sql = "UPDATE account SET activated = 1, activate_token = '' WHERE activate_token = ?";
        try {
            pdo_execute($sql, $token);
            return true;
        } catch (PDOException $e) {
            error_log("Account Activate Failed: " . $e->getMessage());
            return false;
        }
    } else {
        return false;
    }
}

/**
 * Finds account details by username or email for login.
 */
function account_find_by_username_or_email(string $usernameOrEmail): array|false
{
    $loginField = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    $sql = "SELECT username, password, activated FROM account WHERE {$loginField} = ? LIMIT 1";
    return pdo_query_one($sql, $usernameOrEmail);
}

/**
 * Finds account details by username.
 */
function account_find_by_username(string $username): array|false
{
    $sql = "SELECT username, email, activated FROM account WHERE username = ? LIMIT 1";
    return pdo_query_one($sql, $username);
}

function getUserID($username){
    $userID = pdo_query_one('SELECT user.UserID FROM account join user on
    account.username = user.Username where account.username = ?', $username);
    if ($userID===null || $userID==='' || $userID === false) return null;
    return $userID['UserID'];
}

function get_role(string $userID){
    $sql = "SELECT Role FROM user WHERE UserID = ?";
    return pdo_query_value($sql, $userID);
}

/**
 * Finds account details by userID.
 */
function account_find_by_userID(int $userID): array|false
{
    $sql = "SELECT a.username, a.email, a.activated, u.Avatar, u.banner, u.DateOfBirth as dob, u.Location as location, u.AboutField as About, u.Joined as created_at
            FROM account a
            JOIN user u ON a.username = u.Username
            WHERE u.UserID = ? LIMIT 1";
    return pdo_query_one($sql, $userID);
}

/**
 * Updates user profile information
 */
function update_user_profile(int $userID, array $data): bool
{
    try {
        // Get current user data to check for existing avatar/banner
        $currentUserData = pdo_query_one("SELECT Avatar, banner FROM user WHERE UserID = ?", $userID);

        // Update user table
        $userFields = [];
        $userParams = [];

        if (isset($data['dob'])) {
            $userFields[] = "DateOfBirth = ?";
            $userParams[] = $data['dob'];
        }

        if (isset($data['location'])) {
            $userFields[] = "Location = ?";
            $userParams[] = $data['location'];
        }

        if (isset($data['about'])) {
            $userFields[] = "AboutField = ?";
            $userParams[] = $data['about'];
        }

        // Handle avatar update and delete old file
        if (isset($data['avatar'])) {
            $userFields[] = "Avatar = ?";
            $userParams[] = $data['avatar'];

            // Delete old avatar file if it exists and is not the default
            if ($currentUserData && !empty($currentUserData['Avatar']) &&
                $currentUserData['Avatar'] !== 'avatar_default.png') {
                $oldAvatarPath = __DIR__ . "/../IMG/avatars/" . $currentUserData['Avatar'];
                if (file_exists($oldAvatarPath)) {
                    @unlink($oldAvatarPath); // Use @ to suppress errors if file can't be deleted
                }
            }
        }

        // Handle banner update and delete old file
        if (isset($data['banner'])) {
            $userFields[] = "banner = ?";
            $userParams[] = $data['banner'];

            // Delete old banner file if it exists
            if ($currentUserData && !empty($currentUserData['banner'])) {
                $oldBannerPath = __DIR__ . "/../IMG/banners/" . $currentUserData['banner'];
                if (file_exists($oldBannerPath)) {
                    @unlink($oldBannerPath); // Use @ to suppress errors if file can't be deleted
                }
            }
        }

        if (!empty($userFields)) {
            $userParams[] = $userID; // Add userID as the last parameter
            $userSql = "UPDATE user SET " . implode(", ", $userFields) . " WHERE UserID = ?";
            pdo_execute($userSql, ...$userParams);
        }

        // Update preferences table if needed (for email preferences, DOB visibility, etc.)
        // This would require creating a new preferences table

        return true;
    } catch (PDOException $e) {
        error_log("Profile Update Failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Saves a base64 image to the server and returns the filename
 */
function save_base64_image(string $base64Data, string $folder, int $userID): string
{
    // Extract the image data from the base64 string
    if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches)) {
        $imageType = $matches[1];
        $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        $decodedData = base64_decode($base64Data);

        if ($decodedData === false) {
            throw new Exception("Failed to decode base64 image data");
        }

        // Create directory if it doesn't exist
        $uploadDir = __DIR__ . "/../IMG/{$folder}/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate a unique filename
        $filename = "{$folder}_{$userID}_" . time() . ".{$imageType}";
        $filePath = "{$uploadDir}{$filename}";

        // Save the file
        if (file_put_contents($filePath, $decodedData) === false) {
            throw new Exception("Failed to save image file");
        }

        return $filename;
    } else {
        throw new Exception("Invalid base64 image data");
    }
}

/**
 * Stores a password reset token for a user.
 *
 * @param string $username The username
 * @param string $reset_token The reset token
 * @param int $expires_at Timestamp when the token expires
 * @return bool True if successful, false otherwise
 */
function account_store_reset_token(string $username, string $reset_token, int $expires_at): bool
{
    try {
        $sql = "UPDATE account SET reset_token = ?, reset_token_expiry = FROM_UNIXTIME(?) WHERE username = ?";
        pdo_execute($sql, $reset_token, $expires_at, $username);
        return true;
    } catch (PDOException $e) {
        error_log("Failed to store reset token: " . $e->getMessage());
        return false;
    }
}

/**
 * Finds a user by their reset token.
 *
 * @param string $token The reset token
 * @return array|false User data if found and token is valid, false otherwise
 */
function account_find_by_reset_token(string $token): array|false
{
    try {
        $sql = "SELECT username, email FROM account
                WHERE reset_token = ?
                AND reset_token_expiry > NOW()
                LIMIT 1";
        return pdo_query_one($sql, $token);
    } catch (PDOException $e) {
        error_log("Error finding reset token: " . $e->getMessage());
        return false;
    }
}

/**
 * Updates a user's password and clears their reset token.
 *
 * @param string $username The username
 * @param string $hashed_password The new hashed password
 * @return bool True if successful, false otherwise
 */
function account_update_password(string $username, string $hashed_password): bool
{
    try {
        $sql = "UPDATE account
                SET password = ?, reset_token = NULL, reset_token_expiry = NULL
                WHERE username = ?";
        pdo_execute($sql, $hashed_password, $username);
        return true;
    } catch (PDOException $e) {
        error_log("Failed to update password: " . $e->getMessage());
        return false;
    }
}
