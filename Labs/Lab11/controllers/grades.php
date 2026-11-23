<?php
// Atheer AlSulami | 2307149 | CPIT 405 Lab 11
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../models/GradeModel.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

function reply(int $code, array $payload): never
{
    http_response_code($code);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Model returns an array -> controller converts the array into JSON.
        reply(200, ['success' => true, 'grades' => getAllGrades()]);
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        reply(405, ['success' => false, 'message' => 'Only GET and POST are supported.']);
    }

    $token = $_POST['csrf_token'] ?? '';
    $expected = $_SESSION['lab11_csrf'] ?? '';
    if (!is_string($token) || !is_string($expected) ||
        $expected === '' || !hash_equals($expected, $token)) {
        reply(403, ['success' => false, 'message' => 'Invalid session. Refresh the page and retry.']);
    }

    $action = (string) ($_POST['action'] ?? '');
    if (!in_array($action, ['create', 'update', 'delete'], true)) {
        reply(400, ['success' => false, 'message' => 'Invalid action.']);
    }

    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
    if ($action !== 'create' && ($id === false || $id === null || $id < 1)) {
        reply(422, ['success' => false, 'message' => 'Invalid grade ID.']);
    }

    if ($action !== 'delete') {
        $name = trim((string) ($_POST['name'] ?? ''));
        $rawTotal = trim((string) ($_POST['total'] ?? ''));
        $total = filter_var($rawTotal, FILTER_VALIDATE_FLOAT);
        if ($name === '' || strlen($name) > 100 ||
            $total === false || !is_finite((float) $total) ||
            $total < 0 || $total > 5) {
            reply(422, ['success' => false, 'message' => 'Enter a name (1-100 bytes) and a grade between 0 and 5.']);
        }
    }

    if ($action === 'create') {
        insertGrade($name, (float) $total);
    } elseif ($action === 'update') {
        updateGrade((int) $id, $name, (float) $total);
    } else {
        deleteGrade((int) $id);
    }

    reply(200, [
        'success' => true,
        'message' => 'Grade ' . ($action === 'create' ? 'added' : ($action === 'update' ? 'updated' : 'deleted')) . ' successfully.',
        'grades' => getAllGrades(),
    ]);
} catch (PDOException $exception) {
    // Do not expose database credentials or SQL error details to a browser.
    reply(503, [
        'success' => false,
        'message' => 'MariaDB is unavailable or the database is not initialized. See the README.',
    ]);
} catch (Throwable $exception) {
    reply(500, ['success' => false, 'message' => 'Unexpected server error.']);
}
