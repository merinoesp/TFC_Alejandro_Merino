<?php
/**
 * Security helpers — incluir en cualquier página que necesite CSRF o headers.
 */

class Security
{
    // ── HTTP Security Headers ───────────────────────────────────────────────
    public static function setHeaders(): void
    {
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https://placehold.co;");
    }

    // ── CSRF token ──────────────────────────────────────────────────────────
    public static function generateCsrf(): string
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrf(string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    // ── Rate limiting (file-based, sin Redis) ───────────────────────────────
    public static function rateLimit(string $key, int $max = 10, int $windowSecs = 60): bool
    {
        $file = sys_get_temp_dir() . '/rl_' . md5($key) . '.json';
        $now  = time();
        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : ['count' => 0, 'window' => $now];
        if ($now - $data['window'] > $windowSecs) {
            $data = ['count' => 0, 'window' => $now];
        }
        $data['count']++;
        file_put_contents($file, json_encode($data));
        return $data['count'] <= $max;
    }

    // ── Input sanitization ──────────────────────────────────────────────────
    public static function sanitizeString(string $input, int $maxLen = 255): string
    {
        return mb_substr(trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8')), 0, $maxLen);
    }

    public static function sanitizeInt(mixed $input, int $min = 0, int $max = PHP_INT_MAX): int|false
    {
        return filter_var($input, FILTER_VALIDATE_INT, ['options' => ['min_range' => $min, 'max_range' => $max]]);
    }
}
