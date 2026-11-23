<?php
// Atheer AlSulami | 2307149 | CPIT 405 Lab 11
declare(strict_types=1);
session_start();

if (empty($_SESSION['lab11_csrf'])) {
    $_SESSION['lab11_csrf'] = bin2hex(random_bytes(32));
}
require __DIR__ . '/../views/page1.php';
