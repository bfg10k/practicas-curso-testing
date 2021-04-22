<?php


namespace Test\Unit\BookCar\Doubles;


use Model\Booking;
use Model\Car;
use Model\User;
use Service\BookingRepository;
use Service\CarFinder;
use Service\ConfirmationNotifierInterface;
use UseCase\BookCar;

class BookCarMock extends BookCar
{


    private $timesCalled = 0;

    public function __construct() {

    }

    public function execute(User $user, int $carId): \Model\Booking
    {
        $this->timesCalled++;
        return new Booking(1, $user, Car::proxyWithId($carId));
    }

    public function timesCalled(){
        return $this->timesCalled;
    }

}