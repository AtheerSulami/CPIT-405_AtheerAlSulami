<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
/* Assessment 1: iterative power function with exactly two parameters. */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

function power(float $base, int $exponent): float
{
    $result = 1.0;
    for ($i = 0; $i < abs($exponent); $i++) {
        $result *= $base;
    }
    return $exponent < 0 ? 1.0 / $result : $result;
}

$baseRaw = (string) ($_POST['base'] ?? '');
$exponentRaw = (string) ($_POST['exponent'] ?? '');
$base = filter_var($baseRaw, FILTER_VALIDATE_FLOAT);
$exponent = filter_var($exponentRaw, FILTER_VALIDATE_INT);
$result = null;
$error = '';

if ($base === false || $exponent === false || abs($base) > 1000 ||
    $exponent < -20 || $exponent > 20) {
    $error = 'Enter a base from -1000 to 1000 and an integer exponent from -20 to 20.';
} elseif ($base == 0.0 && $exponent < 0) {
    $error = 'Zero cannot be raised to a negative power.';
} else {
    $result = power((float) $base, (int) $exponent);
}
require __DIR__ . '/../views/power.php';
