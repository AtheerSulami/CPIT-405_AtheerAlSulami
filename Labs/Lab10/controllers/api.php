<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
/* The dashboard calls this controller using the Fetch API (AJAX). */
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../models/TaskModel.php';

try {
    echo json_encode(['ok' => true, 'tasks' => getTasks()],
        JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
} catch (Throwable $exception) {
    http_response_code(503);
    echo json_encode(['ok' => false, 'message' => 'Database unavailable.']);
}
