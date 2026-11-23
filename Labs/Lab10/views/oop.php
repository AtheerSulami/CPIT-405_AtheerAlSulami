<?php /* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */ ?>
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>UML / OOP</title><link rel="stylesheet" href="../css/style.css"></head>
<body><main class="shell compact">
<nav class="nav"><a href="index.php">← Back to dashboard</a></nav>
<section class="panel">
  <p class="eyebrow">ASSESSMENT 02</p><h1>UML → PHP classes</h1>
  <p>This is the class diagram translated into executable PHP, with <strong>Professor extends Person</strong>.</p>
  <div class="class-diagram">
    <div class="class-box"><strong>Person</strong><p>name: String</p><p>speak()</p><p>getName(): String</p></div>
    <div class="class-arrow">△<span>inherits</span></div>
    <div class="class-box"><strong>Professor</strong><p>salary: Float</p><p>Teach()</p></div>
  </div>
  <h2>Live PHP output</h2>
  <ul class="db-list">
    <li>Person: <?= htmlspecialchars($person->speak(), ENT_QUOTES, 'UTF-8') ?></li>
    <li>getName(): <?= htmlspecialchars($professor->getName(), ENT_QUOTES, 'UTF-8') ?></li>
    <li>Inherited speak(): <?= htmlspecialchars($professor->speak(), ENT_QUOTES, 'UTF-8') ?></li>
    <li>Teach(): <?= htmlspecialchars($professor->Teach(), ENT_QUOTES, 'UTF-8') ?></li>
  </ul>
  <p>Source: <code>models/Person.php</code></p>
</section></main></body></html>
