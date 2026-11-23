<?php
// Atheer AlSulami | 2307149 | CPIT 405 Lab 11
declare(strict_types=1);
require_once __DIR__ . '/../models/AssessmentModel.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Use GET']);
    exit;
}

// Assessment #3: AJAX requests this PHP endpoint, then logs its JSON to Console.
echo json_encode(getAssessmentGrades(), JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
