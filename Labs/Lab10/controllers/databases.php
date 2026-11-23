<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
require_once __DIR__ . '/../models/DatabaseModel.php';
$databases = [];
$error = '';
try {
    $databases = listDatabaseNames();
} catch (Throwable $exception) {
    $error = 'Unable to retrieve database names. Start MariaDB and check the connection settings.';
}
require __DIR__ . '/../views/databases.php';
