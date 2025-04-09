<?php
require_once __DIR__ . '/db_config.php';

/**
 * Checks if a username already exists in the account table.
 *
 * @param PDO $pdo The PDO database connection object.
 * @param string $username The username to check.
 * @return bool True if the username exists, false otherwise.
 */
function account_check_username_exists(PDO $pdo, string $username): bool
{
    $sql = "SELECT username FROM account WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch() !== false;
}

/**
 * Checks if an email already exists in the account table.
 *
 * @param PDO $pdo The PDO database connection object.
 * @param string $email The email to check.
 * @return bool True if the email exists, false otherwise.
 */
function account_check_email_exists(PDO $pdo, string $email): bool
{
    $sql = "SELECT email FROM account WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch() !== false;
}

/**
 * Adds a new account to the database.
 *
 * @param PDO $pdo The PDO database connection object.
 * @param string $username
 * @param string $hashed_password
 * @param string $email
 * @param string $activation_token
 * @return bool True on success, false on failure.
 */
function account_add(PDO $pdo, string $username, string $hashed_password, string $email, string $activation_token): bool
{
    $sql = "INSERT INTO account (username, password, email, activated, activate_token)
            VALUES (:username, :password, :email, 0, :activate_token)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':activate_token', $activation_token, PDO::PARAM_STR);
    return $stmt->execute();
}

/**
 * Finds an account by its activation token.
 *
 * @param PDO $pdo The PDO database connection object.
 * @param string $token The activation token.
 * @return array|false The user data array (including username, activated) or false if not found.
 */
function account_find_by_token(PDO $pdo, string $token)
{
    $sql = "SELECT username, activated FROM account WHERE activate_token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Activates an account by setting activated = 1 and clearing the token.
 *
 * @param PDO $pdo The PDO database connection object.
 * @param string $token The activation token of the account to activate.
 * @return bool True if the update was successful (affected 1 row), false otherwise.
 */
function account_activate(PDO $pdo, string $token): bool
{
    $sql = "UPDATE account SET activated = 1, activate_token = NULL WHERE activate_token = :token AND activated = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->rowCount() > 0;
}

/**
 * Finds an account by username or email for login.
 *
 * @param PDO $pdo The PDO database connection object.
 * @param string $usernameOrEmail The username or email to search for.
 * @return array|false The user data array (username, password, activated) or false if not found.
 */
function account_find_by_username_or_email(PDO $pdo, string $usernameOrEmail)
{
    $loginField = filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    $sql = "SELECT username, password, activated FROM account WHERE {$loginField} = :loginValue LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':loginValue', $usernameOrEmail, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Finds an account by username.
 *
 * @param PDO $pdo The PDO database connection object.
 * @param string $username The username to search for.
 * @return array|false The user data array or false if not found.
 */
function account_find_by_username(PDO $pdo, string $username)
{
    $sql = "SELECT username, email FROM account WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?> 