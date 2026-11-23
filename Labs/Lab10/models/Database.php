<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
/* All PDO database connections are created in the models layer. */

function serverConnection(): PDO
{
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: '';
    $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";

    return new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}

function databaseConnection(): PDO
{
    $dbName = getenv('DB_NAME') ?: 'cpit405_lab10';
    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $dbName)) {
        throw new RuntimeException('Invalid database name.');
    }

    $connection = serverConnection();
    $connection->exec("USE " . chr(96) . $dbName . chr(96));
    return $connection;
}
