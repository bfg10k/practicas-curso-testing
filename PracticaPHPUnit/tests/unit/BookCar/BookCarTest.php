<?php

namespace Test\Unit\BookCar;

use PHPUnit\Framework\TestCase;
use Service\CarNotFoundException;
use UseCase\BookCar;
use Model\User;
use Model\Booking;
use Service\CarFinder;
use Model\Car;
use Service\DbConnection;
use UseCase\CarNotAvailableException;
use UseCase\MinorsCannotBookCarsException;

class BookCarTest extends TestCase
{

    /**
     * @test
     */
    public function adultsCanBookAvailableCars()
    {

        $userStub = $this->createStub(User::class);
        $userStub->method('getId')
            ->willReturn(1);
        $userStub->method('isAnAdult')
            ->willReturn(true);


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

        $bookCarUseCase = new BookCar($carFinderStub, $dbConnectionStub);
        $booking = $bookCarUseCase->execute(
            $userStub,
            1
        );

        $this->assertInstanceOf(Booking::class, $booking);
    }

    /**
     * @test
     */
    public function adultsCantBookUnavailableCars()
    {
        $this->expectException(CarNotAvailableException::class);

        $dbConnectionDummy = $this->createStub(DbConnection::class);
        $userDummy = $this->createStub(User::class);

        $carStub = $this->createStub(Car::class);
        $carStub->method('isAvailable')
            ->willReturn(false);

        $carFinderStub = $this->createStub(CarFinder::class);
        $carFinderStub->method('find')
            ->willReturn($carStub);

        $bookCarUseCase = new BookCar($carFinderStub, $dbConnectionDummy);

        $bookCarUseCase->execute(
            $userDummy,
            1
        );
    }

    /**
     * @test
     */
    public function adultsCantBookNonExistentCars()
    {
        $this->expectException(CarNotFoundException::class);

        $dbConnectionDummy = $this->createStub(DbConnection::class);
        $userDummy = $this->createStub(User::class);

        $carFinderStub = $this->createStub(CarFinder::class);
        $carFinderStub->method('find')
            ->willThrowException(
                new CarNotFoundException()
            );

        $bookCarUseCase = new BookCar($carFinderStub, $dbConnectionDummy);
        $bookCarUseCase->execute(
            $userDummy,
            1
        );
    }

    /**
     * @test
     */
    public function minorsCannotBookAvailableCars(){
        $this->expectException(MinorsCannotBookCarsException::class);
        $dbConnectionDummy = $this->createStub(DbConnection::class);
        $userStub = $this->createStub(User::class);
        $carStub = $this->createStub(Car::class);
        $carFinderStub = $this->createStub(CarFinder::class);

        $userStub->method('isAnAdult')
            ->willReturn(false);

        $carFinderStub->method('find')
            ->willReturn($carStub);

        $carStub->method('isAvailable')
            ->willReturn(true);

        $bookCarUseCase = new BookCar($carFinderStub, $dbConnectionDummy);

        $bookCarUseCase->execute($userStub, 1);
    }

}