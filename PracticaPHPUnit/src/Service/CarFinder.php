<?php

namespace Service;

use Model\Car;
use Service\DbConnection;

class CarFinder
{
    private DbConnection $dbConnection;

    public function __construct(DbConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /** @throws CarNotFoundException|DbConnectionFailedException */
    public function find(int $id): Car
    {
        $carData = $this->dbConnection->query(
            'SELECT cars.id, cars.model, cars.fuel FROM cars WHERE car.id = ' . $id
        );

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