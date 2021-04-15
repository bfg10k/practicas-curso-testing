<?php

namespace Model;

class Car {

    private int $id;

    private string $model;

    private string $fuel;

    public function __construct(int $id, string $model, string $fuel)
    {
        $this->id = $id;
        $this->model = $model;
        $this->fuel = $fuel;
    }

    public function getId(): int {

    public function __construct(int $id, string $model, string $fuel)
    {
        $this->id = $id;
        $this->model = $model;
        $this->fuel = $fuel;
    }

    public function getId(): int
    {

    }

    public function isAvailable(): bool
    {

    }
}