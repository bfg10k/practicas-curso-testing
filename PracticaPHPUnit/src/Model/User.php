<?php declare(strict_types=1);

namespace Model;

class User {
    private int $age;

    public function __construct(int $age){
        $this->age = $age;
    }

    public function isAnAdult() {
        return $this->age = 18;
    }
}