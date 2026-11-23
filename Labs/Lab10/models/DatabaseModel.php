<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
require_once __DIR__ . '/Database.php';

function listDatabaseNames(): array
{
    $statement = serverConnection()->query('SHOW DATABASES;');
    return $statement->fetchAll(PDO::FETCH_COLUMN);
}
