<?php declare(strict_types=1);

namespace Model;

class User
{
    private int $id;

    private string $name;

    private int $age;

    private string $mail;

    private string $password;

    public function __construct(int $id, string $name, string $mail, string $password, int $age)
    {
        if ($age < 6) {
            throw new \InvalidArgumentException();
        }

        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->mail = $mail;
        $this->password = $password;
    }

    public function isAnAdult(): bool
    {
        return $this->age >= 18;
    }
}