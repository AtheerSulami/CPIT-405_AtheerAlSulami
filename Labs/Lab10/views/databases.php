<?php /* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */ ?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>SHOW DATABASES</title><link rel="stylesheet" href="../css/style.css"></head>
<body><main class="shell compact">
<nav class="nav"><a href="index.php">← Back to dashboard</a></nav>
<section class="panel">
  <p class="eyebrow">ASSESSMENT 03</p><h1>MariaDB databases</h1>
  <p>Retrieved from the database model using the query <code>SHOW DATABASES;</code></p>
  <?php if ($error !== ''): ?>
    <p class="message warning"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
  <?php else: ?>
    <ul class="db-list">
    <?php foreach ($databases as $name): ?>
      <li><?= htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8') ?></li>
    <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</section></main></body></html>
