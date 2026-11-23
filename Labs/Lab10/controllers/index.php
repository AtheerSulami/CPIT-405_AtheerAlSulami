<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
session_start();
require_once __DIR__ . '/../models/TaskModel.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$tasks = [];
$dbError = '';
try {
    $tasks = getTasks();
} catch (Throwable $exception) {
    $dbError = 'Database connection is not ready. Import the SQL file and check your MariaDB settings.';
}
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
require __DIR__ . '/../views/dashboard.php';
