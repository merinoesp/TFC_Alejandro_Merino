<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

header('Content-Type: application/json');

// Rate limit básico: máx 60 peticiones/min por IP
$ip  = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$key = sys_get_temp_dir() . '/rl_' . md5($ip) . '.json';
$now = time();
$rl  = file_exists($key) ? json_decode(file_get_contents($key), true) : ['count' => 0, 'window' => $now];
if ($now - $rl['window'] > 60) { $rl = ['count' => 0, 'window' => $now]; }
$rl['count']++;
file_put_contents($key, json_encode($rl));
if ($rl['count'] > 60) { http_response_code(429); echo json_encode(['error' => 'Too many requests']); exit(); }

$offset = max(0, (int)($_GET['offset'] ?? 0));
$limit  = min(9, max(1, (int)($_GET['limit'] ?? 9)));

$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
$anuncios = $db->listarAnunciosPaginados($offset, $limit);

echo json_encode(['anuncios' => $anuncios]);
