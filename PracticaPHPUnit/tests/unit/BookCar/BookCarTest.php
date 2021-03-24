<?php

namespace Test\Unit\BookCar;

use PHPUnit\Framework\TestCase;
use UseCase\BookCar;
use Model\User;
use Model\Booking;
use Service\CarFinder;
use Model\Car;
use Service\DbConnection;

class BookCarTest extends TestCase {

    /**
     * @test
     */
    public function adultsCanBookAvailableCars() {
        
        $userStub = $this->createStub(User::class);
        $userStub->method('getId')
            ->willReturn(1);


        $dbConnectionStub = $this->createStub(DbConnection::class);
        $dbConnectionStub->method('insert')
            ->willReturn(1);

        $carStub = $this->createStub(Car::class);
        $carStub->method('isAvailable')
            ->willReturn(true);

        $carFinderStub = $this->createStub(CarFinder::class);

        $carFinderStub->method('find')
            ->willReturn(
                $carStub
            );

        $bookCarUseCase  = new BookCar($carFinderStub, $dbConnectionStub);
        $booking = $bookCarUseCase->execute(
            $userStub, 
            1
        );

        $this->assertInstanceOf(Booking::class, $booking);
    }

}