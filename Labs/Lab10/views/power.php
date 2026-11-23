<?php /* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */ ?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Power Result</title><link rel="stylesheet" href="../css/style.css"></head>
<body><main class="shell compact">
<nav class="nav"><a href="index.php">← Back to dashboard</a></nav>
<section class="panel result">
  <p class="eyebrow">ASSESSMENT 01</p><h1>Power function</h1>
  <?php if ($error !== ''): ?>
    <p class="message warning"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
  <?php else: ?>
    <p class="equation"><?= htmlspecialchars((string) $base, ENT_QUOTES, 'UTF-8') ?><sup><?= (int) $exponent ?></sup> = <?= htmlspecialchars(sprintf('%.10g', $result), ENT_QUOTES, 'UTF-8') ?></p>
    <p>Calculated in PHP using a loop, without calling the built-in pow() function.</p>
  <?php endif; ?>
</section></main></body></html>
