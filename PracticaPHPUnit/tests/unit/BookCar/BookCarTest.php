<?php

namespace Test\Unit\BookCar;

use PHPUnit\Framework\TestCase;
use Service\BookingRepository;
use Service\CarNotFoundException;
use Service\ConfirmationNotifierInterface;
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
     * @covers
     */
    public function adultsCanBookAvailableCars()
    {

        $userStub = $this->createStub(User::class);
        $userStub->method('getId')
            ->willReturn(1);
        $userStub->method('isAnAdult')
            ->willReturn(true);



        $carStub = $this->createStub(Car::class);
        $carStub->method('isAvailable')
            ->willReturn(true);


        $carFinderStub = $this->createStub(CarFinder::class);

        $carFinderStub->method('find')
            ->willReturn(
                $carStub
            );

        $bookingRepositoryMock = $this->createMock(BookingRepository::class);
        $bookingRepositoryMock
            ->method('bookCar')
            ->willReturn(new Booking(1, $userStub, $carStub));

        $bookingRepositoryMock->expects($this->exactly(1))
            ->method('commitTransaction');
        $bookingRepositoryMock->expects($this->exactly(1))
            ->method('beginTransaction');
        $bookingRepositoryMock->expects($this->exactly(0))
            ->method('rollBackTransaction');

        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->exactly(1))
            ->method('send');

        $bookCarUseCase = new BookCar(
            $carFinderStub,
            $bookingRepositoryMock,
            $notifierSpy
        );

        $booking = $bookCarUseCase->execute(
            $userStub,
            1
        );

        $this->assertInstanceOf(Booking::class, $booking);
    }

    /**
     * @test
     * @covers
     */
    public function adultsCantBookUnavailableCars()
    {
        $this->expectException(CarNotAvailableException::class);

        $bookingRepositoryDummy = $this->createStub(BookingRepository::class);
        $userDummy = $this->createStub(User::class);

        $carStub = $this->createStub(Car::class);
        $carStub->method('isAvailable')
            ->willReturn(false);

        $carFinderStub = $this->createStub(CarFinder::class);
        $carFinderStub->method('find')
            ->willReturn($carStub);

        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->exactly(0))
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryDummy, $notifierSpy);

        $bookCarUseCase->execute(
            $userDummy,
            1
        );
    }

    /**
     * @test
     * @covers
     */
    public function adultsCantBookNonExistentCars()
    {
        $this->expectException(CarNotFoundException::class);

        $bookingRepositoryDummy = $this->createStub(BookingRepository::class);
        $userDummy = $this->createStub(User::class);

        $carFinderStub = $this->createStub(CarFinder::class);
        $carFinderStub->method('find')
            ->willThrowException(
                new CarNotFoundException()
            );

        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->exactly(0))
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryDummy, $notifierSpy);
        $bookCarUseCase->execute(
            $userDummy,
            1
        );
    }

    /**
     * @test
     * @covers
     */
    public function minorsCannotBookAvailableCars()
    {
        $this->expectException(MinorsCannotBookCarsException::class);
        $bookingRepositoryDummy = $this->createStub(BookingRepository::class);
        $userStub = $this->createStub(User::class);
        $carStub = $this->createStub(Car::class);
        $carFinderStub = $this->createStub(CarFinder::class);

        $userStub->method('isAnAdult')
            ->willReturn(false);

        $carFinderStub->method('find')
            ->willReturn($carStub);

        $carStub->method('isAvailable')
            ->willReturn(true);

        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->exactly(0))
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryDummy, $notifierSpy);

        $bookCarUseCase->execute($userStub, 1);
    }

}