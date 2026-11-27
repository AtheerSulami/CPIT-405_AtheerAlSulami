<?php
// Student: Atheer AlSulami | Student ID: 2307149 | CPIT 405 Lab 10
// Assessment 2: Translate the provided UML diagram into PHP with demo code.

class Person
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function speak(): string
    {
        return 'Hello, my name is ' . $this->name . '.';
    }

    public function getName(): string
    {
        return $this->name;
    }
}

class Professor extends Person
{
    private float $salary;

    public function __construct(string $name, float $salary)
    {
        parent::__construct($name);
        $this->salary = $salary;
    }

    public function Teach(): string
    {
        return $this->getName() . ' is teaching PHP.';
    }
}

$person = new Person('Mohammad');
$professor = new Professor('Dr. Fahad', 15000.0);
$demo = [
    'Person::getName()' => $person->getName(),
    'Person::speak()' => $person->speak(),
    'Professor::getName() (inherited)' => $professor->getName(),
    'Professor::speak() (inherited)' => $professor->speak(),
    'Professor::Teach()' => $professor->Teach(),
];
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lab 10 — Assessment 2</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container narrow">
  <a class="back" href="index.php">← All assessments</a>
  <section class="panel">
    <p class="eyebrow">LAB 10 · ASSESSMENT 02</p>
    <h1>Person and Professor</h1>
    <p>Translation of the UML class diagram into PHP classes.</p>
    <div class="diagram" aria-label="Professor inherits from Person">
      <div class="uml"><strong>Person</strong><span>name: String</span><span>speak()</span><span>getName(): String</span></div>
      <div class="inherit"><span>△</span><small>extends</small></div>
      <div class="uml"><strong>Professor</strong><span>salary: Float</span><span>Teach()</span></div>
    </div>
    <h2>PHP demo output</h2>
    <dl class="output">
    <?php foreach ($demo as $method => $value): ?>
      <div><dt><?= htmlspecialchars($method, ENT_QUOTES, 'UTF-8') ?></dt>
      <dd><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></dd></div>
    <?php endforeach; ?>
    </dl>
  </section>
</main></body>
</html>
