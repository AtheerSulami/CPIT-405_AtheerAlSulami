<?php
// Atheer AlSulami | 2307149 | CPIT 405 Lab 11
$token = htmlspecialchars($_SESSION['lab11_csrf'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="CPIT 405 Lab 11: AJAX, PHP, JSON, XML and MariaDB.">
  <title>CPIT 405 · Lab 11 | AJAX Lab</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/script1.js" defer></script>
</head>
<body>
  <div class="layout" id="app" data-csrf="<?= $token ?>">
    <header class="hero">
      <div class="eyebrow"><span class="dot"></span> CPIT 405 · INTERNET APPLICATIONS</div>
      <div class="hero-content">
        <div>
          <span class="pill">LAB 11</span>
          <h1>AJAX <em>in action.</em></h1>
          <p>Request data asynchronously, parse JSON or XML, and update the interface without reloading the page.</p>
          <div class="student">Atheer AlSulami <span class="separator">/</span> 2307149</div>
        </div>
        <div class="hero-code" aria-hidden="true">
          <div class="code-head"><i></i><i></i><i></i><span>ajax.js</span></div>
          <div class="code-body"><span class="purple">const</span> response = <span class="purple">await</span> fetch(<span class="green">'assessment.php'</span>);<br><span class="purple">const</span> grades = <span class="purple">await</span> response.json();<br>console.log(<span class="green">'JSON data:'</span>, grades);</div>
        </div>
      </div>
    </header>

    <main>
      <div class="overview">
        <div class="metric"><strong>01</strong><span>PHP keyed array</span></div>
        <div class="metric"><strong>02</strong><span>JSON & XML responses</span></div>
        <div class="metric"><strong>03</strong><span>AJAX requests</span></div>
        <div class="metric"><strong>04</strong><span>MariaDB integration</span></div>
      </div>

      <section class="section" aria-labelledby="assessment-title">
        <div class="section-heading">
          <div><div class="kicker">ASSESSMENT · 01—03</div><h2 id="assessment-title">PHP → JSON → Browser Console</h2>
            <p>The PHP array uses student names as keys. Click to request the actual JSON from the PHP controller.</p></div>
          <div class="tag">No page reload</div>
        </div>
        <div class="two-column">
          <div class="surface">
            <div class="surface-head"><strong>Reference dataset</strong><span>Provided in Lab 11</span></div>
            <table class="data-table"><thead><tr><th>Name</th><th>Total</th></tr></thead>
              <tbody><tr><td>Mohammad</td><td>4</td></tr><tr><td>Fahad</td><td>3.5</td></tr></tbody>
            </table>
            <div class="button-bar">
              <button type="button" id="load-json" class="primary">Request JSON</button>
              <button type="button" id="load-xml" class="outline">Request XML</button>
            </div>
          </div>
          <div class="surface">
            <div class="surface-head"><strong>Live AJAX result</strong><span id="format-label">Select a format</span></div>
            <pre id="response-output" aria-live="polite">Click “Request JSON” or “Request XML” to begin.</pre>
            <p id="response-status" class="helper" role="status">Open Developer Tools → Console to inspect the AJAX response.</p>
          </div>
        </div>
      </section>

      <section class="section" aria-labelledby="homework-title">
        <div class="section-heading">
          <div><div class="kicker">HOMEWORK · WEEK 12</div><h2 id="homework-title">AJAX grade manager</h2>
            <p>Event → JavaScript Fetch API → PHP controller → database model → MariaDB → JSON → page update.</p></div>
          <span class="tag">Full CRUD · AJAX POST</span>
        </div>

        <div class="surface manager">
          <div class="toolbar">
            <form id="add-grade" class="add-form" autocomplete="off">
              <label for="student-name">Student name
                <input id="student-name" name="name" type="text" maxlength="100" placeholder="e.g. Atheer" required>
              </label>
              <label for="student-total">Total (0–5)
                <input id="student-total" name="total" type="number" min="0" max="5" step="0.5" placeholder="4.5" required>
              </label>
              <button class="primary" type="submit">+ Add record</button>
            </form>
            <button class="outline" type="button" id="refresh-grades">↻ Refresh from MariaDB</button>
          </div>
          <div id="database-status" class="notice" role="status">Loading records from MariaDB...</div>
          <div class="table-scroll">
            <table class="data-table" id="grades-table">
              <thead><tr><th>ID</th><th>Student name</th><th>Total / 5</th><th>Actions</th></tr></thead>
              <tbody id="grades-body"><tr><td colspan="4" class="empty">Loading...</td></tr></tbody>
            </table>
          </div>
          <p class="helper">All Add, Save, Delete and Refresh actions use AJAX. If the database is offline, a clear error appears above this table.</p>
        </div>
      </section>
    </main>

    <footer>King Abdulaziz University <span>·</span> CPIT 405 <span>·</span> Atheer AlSulami (2307149)</footer>
  </div>
</body>
</html>
