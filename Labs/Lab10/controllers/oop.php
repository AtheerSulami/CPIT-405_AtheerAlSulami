<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
require_once __DIR__ . '/../models/Person.php';
$person = new Person('Atheer');
$professor = new Professor('Dr. Sara', 15000.0);
require __DIR__ . '/../views/oop.php';
