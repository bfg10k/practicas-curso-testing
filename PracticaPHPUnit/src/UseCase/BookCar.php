<?php

namespace UseCase;

use Model\Booking;
use Model\Car;
use Model\User;
use Service\CarFinder;
use Service\DbConnection;

class BookCar
{
    private CarFinder $carFinder;
    private DbConnection $connection;

    public function __construct(CarFinder $carFinder, DbConnection $dbConnection)
    {
        $this->carFinder = $carFinder;
        $this->connection = $dbConnection;
    }

    public function execute(User $user, int $carId)
    {
        $car = $this->carFinder->find($carId);
        if(!$car->isAvailable()){
            throw new \Exception();
        }
        $booking = $this->bookCar($user, $car);

        return $booking;
    }

    private function bookCar(User $user, Car $car)
    {
        $bookingId = $this->connection->insert(
            'INSERT INTO bookings (userId, carId)
                 VALUES ('.$user->getId().', '.$car->getId().')'
        );

        return new Booking($bookingId, $user, $car);
    }
}