<?php

// Escape untrusted values for HTML text and quoted attributes at render time.
function h(mixed $value): string
{
    if (!is_string($value) && !is_int($value) && !is_float($value) && !is_bool($value) && $value !== null) {
        return '';
    }

    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Route IDs must be positive integers, not arrays or arbitrary request strings.
function positive_int(mixed $value): ?int
{
    if (!is_string($value) && !is_int($value)) {
        return null;
    }

    $integer = filter_var($value, FILTER_VALIDATE_INT);
    return $integer !== false && $integer > 0 ? $integer : null;
}

function start_app_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        // Centralize strict, HTTP-only, same-site session cookies before any route starts a session.
        ini_set('session.use_strict_mode', '1');
        $cookie = session_get_cookie_params();
        session_set_cookie_params([
            'lifetime' => $cookie['lifetime'],
            'path' => $cookie['path'],
            'domain' => $cookie['domain'],
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

function csrf_token(): string
{
    start_app_session();
    if (!isset($_SESSION['csrf_token'])) {
        // One unpredictable per-session token protects every state-changing form.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

function verify_csrf_token(mixed $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
