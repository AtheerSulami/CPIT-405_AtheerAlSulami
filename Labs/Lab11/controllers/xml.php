<?php
// Atheer AlSulami | 2307149 | CPIT 405 Lab 11
declare(strict_types=1);
require_once __DIR__ . '/../models/AssessmentModel.php';

header('Content-Type: application/xml; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<grades>';
foreach (getAssessmentGrades() as $name => $total) {
    echo '<student><name>'
        . htmlspecialchars((string) $name, ENT_XML1, 'UTF-8')
        . '</name><total>' . htmlspecialchars((string) $total, ENT_XML1, 'UTF-8')
        . '</total></student>';
}
echo '</grades>';
