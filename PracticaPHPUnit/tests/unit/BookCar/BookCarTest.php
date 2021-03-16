<?php


namespace Test\Unit\BookCar;

use Model\Booking;
use Model\Car;
use Model\User;
use PHPUnit\Framework\TestCase;
use Service\CarFinder;
use Service\DbConnection;
use UseCase\BookCar;

class BookCarTest extends TestCase
{
    /**
     * @test
     */
    public function adultsCanBookAvailableCars()
    {
        $dummyConnection = $this->createStub(DbConnection::class, []);
        $stubCarFinder = $this->createStub(CarFinder::class);
        $stubCar = $this->createStub(Car::class);
        $stubCar->method('isAvailable')
            ->willReturn(true);
        $stubCarFinder->method('find')
            ->willReturn($stubCar);

        $bookCarUseCase = new BookCar($stubCarFinder, $dummyConnection);
        $stubUser = $this->createStub(User::class);
        $stubUser->method('getId')
            ->willReturn(1);

        $booking = $bookCarUseCase->execute($stubUser, 1);
        $this->assertInstanceOf(Booking::class, $booking);
    }
}