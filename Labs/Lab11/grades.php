<?php
// Student: Atheer AlSulami | Student ID: 2307149 | CPIT 405 Lab 11
// Assessment 1: Store the provided table as an associative PHP array (names are keys).
$grades = [
    'Mohammad' => 4,
    'Fahad' => 3.5,
];

// Assessment 2: Convert the associative array into JSON.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
echo json_encode($grades, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
