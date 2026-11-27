<?php
// Student: Atheer AlSulami | Student ID: 2307149 | CPIT 405 Lab 10
// Assessment 3: Simple database connection and SHOW DATABASES.

$databases = [];
$error = '';

try {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASSWORD');
    $password = $password === false ? '' : $password;

    // No database/schema is required for SHOW DATABASES.
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $statement = $pdo->query('SHOW DATABASES;');
    $databases = $statement->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $exception) {
    $error = 'Could not connect to MariaDB. Start the database server and check your connection settings.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lab 10 — Assessment 3</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container narrow">
  <a class="back" href="index.php">← All assessments</a>
  <section class="panel">
    <p class="eyebrow">LAB 10 · ASSESSMENT 03</p>
    <h1>MariaDB connection</h1>
    <p>Run the SQL query <code>SHOW DATABASES;</code> and display the database names.</p>
    <?php if ($error !== ''): ?>
      <p class="alert" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php else: ?>
      <p class="success">Connected to MariaDB successfully.</p>
      <ul class="database-list">
        <?php foreach ($databases as $databaseName): ?>
          <li><?= htmlspecialchars((string) $databaseName, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
</main></body>
</html>
