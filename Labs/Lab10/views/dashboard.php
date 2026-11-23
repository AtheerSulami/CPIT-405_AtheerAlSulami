<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
function h(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CPIT 405 | Lab 10</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/app.js" defer></script>
</head>
<body>
<main class="shell">
  <header class="hero">
    <p class="eyebrow">KING ABDULAZIZ UNIVERSITY · CPIT 405</p>
    <h1>Lab 10 <span>PHP & MariaDB</span></h1>
    <p>Server-side programming, OOP inheritance, SQL and AJAX — working examples.</p>
    <div class="identity">Atheer AlSulami <span>·</span> 2307149</div>
  </header>

  <nav class="nav" aria-label="Lab navigation">
    <a class="selected" href="index.php">Dashboard</a>
    <a href="oop.php">UML & OOP demo</a>
    <a href="databases.php">SHOW DATABASES</a>
  </nav>

  <?php if ($flash !== ''): ?>
    <p class="message" role="status"><?= h($flash) ?></p>
  <?php endif; ?>
  <?php if ($dbError !== ''): ?>
    <p class="message warning" role="alert"><?= h($dbError) ?></p>
  <?php endif; ?>

  <div class="grid">
    <section class="panel">
      <div class="section-heading">
        <span class="step">01</span>
        <div><h2>Power calculator</h2><p>Assessment 1 · iterative PHP function</p></div>
      </div>
      <form method="post" action="power.php" class="form-grid">
        <label>Base number
          <input name="base" type="number" step="any" min="-1000" max="1000" value="2" required>
        </label>
        <label>Exponent
          <input name="exponent" type="number" step="1" min="-20" max="20" value="5" required>
        </label>
        <button type="submit">Calculate power</button>
      </form>
    </section>

    <section class="panel">
      <div class="section-heading">
        <span class="step">02</span>
        <div><h2>Class inheritance</h2><p>Assessment 2 · Person & Professor</p></div>
      </div>
      <p>The <strong>Professor</strong> class extends <strong>Person</strong>, inheriting its name and methods.</p>
      <div class="inheritance"><span>Person</span><span>↑ extends</span><span>Professor</span></div>
      <a class="action-link" href="oop.php">View PHP demo</a>
    </section>
  </div>

  <section class="panel wide">
    <div class="section-heading">
      <span class="step">03</span>
      <div><h2>MariaDB task manager</h2><p>Models handle all SQL; controllers process all forms.</p></div>
    </div>
    <form method="post" action="tasks.php" class="create-form">
      <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
      <input type="hidden" name="action" value="create">
      <label class="grow">Task title
        <input type="text" name="title" maxlength="100" placeholder="Write a new task..." required>
      </label>
      <button type="submit" <?= $dbError !== '' ? 'disabled' : '' ?>>Add task</button>
    </form>

    <?php if (empty($tasks)): ?>
      <p class="empty">No tasks to show. Import Documents/db-install-statements.sql to add the sample data.</p>
    <?php else: ?>
      <div class="tasks">
        <?php foreach ($tasks as $task): ?>
          <div class="task-row">
            <form method="post" action="tasks.php" class="task-edit">
              <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
              <input type="hidden" name="action" value="update">
              <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
              <input aria-label="Task title" name="title" maxlength="100" value="<?= h($task['title']) ?>" required>
              <select aria-label="Task status" name="status">
                <?php foreach (['pending' => 'Pending', 'in_progress' => 'In progress', 'done' => 'Done'] as $value => $label): ?>
                  <option value="<?= h($value) ?>" <?= $task['status'] === $value ? 'selected' : '' ?>><?= h($label) ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="secondary">Save</button>
            </form>
            <form method="post" action="tasks.php">
              <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
              <button type="submit" class="danger">Delete</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <section class="panel wide">
    <div class="section-heading">
      <span class="step">04</span>
      <div><h2>AJAX live snapshot</h2><p>Fetch API requests JSON from the PHP controller without reloading.</p></div>
    </div>
    <button id="refresh" type="button" class="secondary">Refresh from server</button>
    <span id="ajax-status" class="status" role="status">Ready</span>
    <ul id="live-tasks" class="live-list"></ul>
  </section>

  <footer>CPIT 405 · Atheer AlSulami · 2307149</footer>
</main>
</body>
</html>
