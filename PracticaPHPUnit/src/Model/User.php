<?php declare(strict_types=1);

namespace Model;

class User
{
    private int $age;

    public function __construct(int $age)
    {
        if ($age < 6) {
            throw new \InvalidArgumentException();
        }

        $this->age = $age;
    }

    public function isAnAdult(): bool
    {
        return $this->age >= 18;
    }
}