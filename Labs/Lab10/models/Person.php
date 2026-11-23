<?php
/* Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10 */
/* UML translation: Professor inherits from Person. */
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
