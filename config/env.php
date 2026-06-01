<?php

/**
 * Load key=value pairs from a .env file into $_ENV and getenv().
 */
function load_dotenv(string $path): void
{
    if (!is_readable($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (!str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        $value = trim($value, "\"'");

        $_ENV[$name] = $value;
        putenv("{$name}={$value}");
    }
}

function env(string $key, ?string $default = null): ?string
{
    if (array_key_exists($key, $_ENV)) {
        $value = $_ENV[$key];
        return $value === '' ? $default : $value;
    }

    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }

    return $value;
}
