<?php
// Student: Atheer AlSulami | Student ID: 2307149 | CPIT 405 Lab 10
// Assessment 1: Implement a power function taking exactly two parameters.

function calculatePower(float $base, int $exponent): float
{
    if ($base == 0.0 && $exponent < 0) {
        throw new InvalidArgumentException('Zero cannot have a negative exponent.');
    }

    $result = 1.0;
    for ($i = 0; $i < abs($exponent); $i++) {
        $result *= $base;
    }

    return $exponent < 0 ? 1.0 / $result : $result;
}

$baseInput = (string) ($_GET['base'] ?? '2');
$exponentInput = (string) ($_GET['exponent'] ?? '5');
$base = filter_var($baseInput, FILTER_VALIDATE_FLOAT);
$exponent = filter_var($exponentInput, FILTER_VALIDATE_INT);
$error = '';
$result = null;

if ($base === false || $exponent === false || abs($base) > 1000 ||
    $exponent < -20 || $exponent > 20) {
    $error = 'Enter a base from -1000 to 1000 and an integer exponent from -20 to 20.';
} else {
    try {
        $result = calculatePower((float) $base, (int) $exponent);
        if (!is_finite($result)) {
            $error = 'The result is too large.';
        }
    } catch (InvalidArgumentException $exception) {
        $error = $exception->getMessage();
    }
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lab 10 — Assessment 1</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container narrow">
  <a class="back" href="index.php">← All assessments</a>
  <div class="panel">
    <p class="eyebrow">LAB 10 · ASSESSMENT 01</p>
    <h1>Power function</h1>
    <p>Enter two parameters to call <code>calculatePower(base, exponent)</code>.</p>
    <form method="get" class="form-row">
      <label>Base <input name="base" type="number" step="any" min="-1000" max="1000" value="<?= escape($baseInput) ?>" required></label>
      <label>Exponent <input name="exponent" type="number" step="1" min="-20" max="20" value="<?= escape($exponentInput) ?>" required></label>
      <button type="submit">Calculate</button>
    </form>
    <?php if ($error !== ''): ?>
      <p class="alert" role="alert"><?= escape($error) ?></p>
    <?php else: ?>
      <p class="result"><?= escape((string) $base) ?><sup><?= (int) $exponent ?></sup> = <?= escape(sprintf('%.12g', $result)) ?></p>
      <p>The result is calculated using a <code>for</code> loop, not <code>pow()</code>.</p>
    <?php endif; ?>
  </div>
</main></body>
</html>
