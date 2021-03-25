<?php

namespace Service;

use Model\Car;

class CarFinder
{
    private DbConnection $connection;

    public function __construct(DbConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws CarNotFoundException
     */
    public function find(int $id): Car
    {
        $carData = $this->connection->query('SELECT * FROM cars WHERE car.id = ' . $id);
        if (null === $carData) {
            throw new CarNotFoundException();
        }

        return new Car(
            $carData['id'],
            $carData['model'],
            $carData['fuel']
        );
    }
}