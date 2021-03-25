<?php

namespace UseCase;

use Service\DbConnection;
use Service\CarFinder;
use Model\User;
use Model\Car;
use Model\Booking;
use Service\InsertException;

class BookCar {

    private CarFinder $carFinder;
    private DbConnection $dbConnection;

    public function __construct(CarFinder $carFinder, DbConnection $dbConnection){
        $this->carFinder = $carFinder;
        $this->dbConnection = $dbConnection;
    }

    /**
     * @throws CarNotAvailableException|InsertException|MinorsCannotBookCarsException
     */
    public function execute(User $user, int $carId): Booking
    {
        $car = $this->carFinder->find($carId);

        if(!$car->isAvailable()){
            throw new CarNotAvailableException();
        }

        if(!$user->isAnAdult()){
            throw new MinorsCannotBookCarsException();
        }

        return $this->bookCar($user, $car);
    }

    /**
     * @throws InsertException
     */
    private function bookCar(User $user, Car $car): Booking {
        $bookingId = $this->dbConnection->insert(
            'INSERT INTO bookings (userId, carId) VALUES('.$user->getId().', '.
            $car->getId().')'
        );

        return new Booking($bookingId, $user, $car);
    }
}
