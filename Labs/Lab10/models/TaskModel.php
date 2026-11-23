<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
require_once __DIR__ . '/Database.php';

function getTasks(): array
{
    return databaseConnection()
        ->query('SELECT id, title, status, created_at FROM tasks ORDER BY id DESC')
        ->fetchAll();
}

function createTask(string $title): void
{
    $statement = databaseConnection()->prepare(
        'INSERT INTO tasks (title, status) VALUES (:title, :status)'
    );
    $statement->execute(['title' => $title, 'status' => 'pending']);
}

function updateTask(int $id, string $title, string $status): void
{
    $statement = databaseConnection()->prepare(
        'UPDATE tasks SET title = :title, status = :status WHERE id = :id'
    );
    $statement->execute(['title' => $title, 'status' => $status, 'id' => $id]);
}

function deleteTask(int $id): void
{
    $statement = databaseConnection()->prepare('DELETE FROM tasks WHERE id = :id');
    $statement->execute(['id' => $id]);
}
