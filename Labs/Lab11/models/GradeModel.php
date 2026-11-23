<?php
// Atheer AlSulami | 2307149 | CPIT 405 Lab 11
declare(strict_types=1);
require_once __DIR__ . '/Database.php';

// The controller calls these model methods; only the model touches the database.
function getAllGrades(): array
{
    $statement = database()->query('SELECT id, name, total FROM grades ORDER BY id');
    return $statement->fetchAll();
}

function insertGrade(string $name, float $total): void
{
    $statement = database()->prepare(
        'INSERT INTO grades (name, total) VALUES (:name, :total)'
    );
    $statement->execute([':name' => $name, ':total' => $total]);
}

function updateGrade(int $id, string $name, float $total): void
{
    $statement = database()->prepare(
        'UPDATE grades SET name = :name, total = :total WHERE id = :id'
    );
    $statement->execute([':name' => $name, ':total' => $total, ':id' => $id]);
}

function deleteGrade(int $id): void
{
    $statement = database()->prepare('DELETE FROM grades WHERE id = :id');
    $statement->execute([':id' => $id]);
}
