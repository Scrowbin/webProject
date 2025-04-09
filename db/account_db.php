<?php
require_once __DIR__ . '/pdo.php';

/**
 * Checks if a username already exists in the account table.
 *
 * @param string $username The username to check.
 * @return bool True if the username exists, false otherwise.
 */
function account_check_username_exists(string $username): bool
{
    $sql = "SELECT username FROM account WHERE username = ? LIMIT 1";
    return pdo_query_one($sql, $username) !== false;
}

/**
 * Checks if an email already exists in the account table.
 *
 * @param string $email The email to check.
 * @return bool True if the email exists, false otherwise.
 */
function account_check_email_exists(string $email): bool
{
    $sql = "SELECT email FROM account WHERE email = ? LIMIT 1";
    return pdo_query_one($sql, $email) !== false;
}

/**
 * Adds a new account to the database.
 *
 * @param string $username
 * @param string $hashed_password
 * @param string $email
 * @param string $activation_token
 * @return bool True on success, false on failure.
 */
function account_add(string $username, string $hashed_password, string $email, string $activation_token): bool
{
    $sql = "INSERT INTO account (username, password, email, activated, activate_token)
            VALUES (?, ?, ?, 0, ?)";
    try {
        pdo_execute($sql, $username, $hashed_password, $email, $activation_token);
        return true; // Assume success if no exception
    } catch (PDOException $e) {
        // Log error if needed, pdo_execute already throws
        error_log("Account Add Failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Finds an account by its activation token.
 *
 * @param string $token The activation token.
 * @return array|false The user data array (including username, activated) or false if not found.
 */
function account_find_by_token(string $token)
{
    $sql = "SELECT username, activated FROM account WHERE activate_token = ?";
    return pdo_query_one($sql, $token);
}

/**
 * Activates an account by setting activated = 1 and clearing the token.
 *
 * @param string $token The activation token of the account to activate.
 * @return bool True if the update was successful (affected 1 row), false otherwise.
 */
function account_activate(string $token): bool
{
    // First check if token exists and account is not activated
    $account = account_find_by_token($token); // Use the function above
    if ($account && !$account['activated']) {
        $sql = "UPDATE account SET activated = 1, activate_token = NULL WHERE activate_token = ?";
        try {
            pdo_execute($sql, $token);
            return true;
        } catch (PDOException $e) {
            error_log("Account Activate Failed: " . $e->getMessage());
            return false;
        }
    } else {
        // Token not found or account already activated
        return false;
    }
}

/**
 * Finds an account by username or email for login.
 *
 * @param string $usernameOrEmail The username or email to search for.
 * @return array|false The user data array (username, password, activated) or false if not found.
 */
function account_find_by_username_or_email(string $usernameOrEmail)
{
    $loginField = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    // Note: Cannot use placeholder for column name, hence direct injection (ensure $loginField is safe)
    $sql = "SELECT username, password, activated FROM account WHERE {$loginField} = ? LIMIT 1";
    return pdo_query_one($sql, $usernameOrEmail);
}

/**
 * Finds an account by username.
 *
 * @param string $username The username to search for.
 * @return array|false The user data array or false if not found.
 */
function account_find_by_username(string $username)
{
    $sql = "SELECT username, email FROM account WHERE username = ? LIMIT 1";
    return pdo_query_one($sql, $username);
}

?> 