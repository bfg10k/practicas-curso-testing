<?php

namespace Model;

class Car {

    private int $id;

    private string $model;

    private string $fuel;

    private bool $available;

    public function __construct(int $id, string $model, string $fuel, bool $available = true)
    {
        $this->id = $id;
        $this->model = $model;
        $this->fuel = $fuel;
        $this->available = $available;
    }

    public function getId(): int {
        return $this->id;
    }

    public function isAvailable(): bool {
        return $this->available;
    }
}