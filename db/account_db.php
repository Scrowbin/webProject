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

function get_role(string $userID){
    $sql = "SELECT Role FROM user WHERE UserID = ?";
    return pdo_query_value($sql, $userID);
}

?>