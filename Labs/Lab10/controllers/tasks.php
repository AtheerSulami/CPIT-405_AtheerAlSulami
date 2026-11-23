<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
session_start();
require_once __DIR__ . '/../models/TaskModel.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$providedToken = $_POST['csrf_token'] ?? '';
$sessionToken = $_SESSION['csrf_token'] ?? '';
if ($sessionToken === '' || !is_string($providedToken) ||
    !hash_equals($sessionToken, $providedToken)) {
    http_response_code(403);
    exit('Invalid form token. Reload the dashboard.');
}

try {
    $action = $_POST['action'] ?? '';
    $title = trim((string) ($_POST['title'] ?? ''));
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
    $status = (string) ($_POST['status'] ?? 'pending');

    if ($action === 'create') {
        if ($title === '' || mb_strlen($title) > 100) {
            throw new InvalidArgumentException('Title must contain 1 to 100 characters.');
        }
        createTask($title);
        $_SESSION['flash'] = 'Task created successfully.';
    } elseif ($action === 'update') {
        if (!$id || $id < 1 || $title === '' || mb_strlen($title) > 100 ||
            !in_array($status, ['pending', 'in_progress', 'done'], true)) {
            throw new InvalidArgumentException('Enter a valid title and status.');
        }
        updateTask((int) $id, $title, $status);
        $_SESSION['flash'] = 'Task updated successfully.';
    } elseif ($action === 'delete') {
        if (!$id || $id < 1) {
            throw new InvalidArgumentException('Invalid task ID.');
        }
        deleteTask((int) $id);
        $_SESSION['flash'] = 'Task deleted successfully.';
    } else {
        throw new InvalidArgumentException('Unknown action.');
    }
} catch (InvalidArgumentException $exception) {
    $_SESSION['flash'] = $exception->getMessage();
} catch (Throwable $exception) {
    $_SESSION['flash'] = 'Database operation failed. Check your MariaDB connection.';
}

header('Location: index.php');
exit;
