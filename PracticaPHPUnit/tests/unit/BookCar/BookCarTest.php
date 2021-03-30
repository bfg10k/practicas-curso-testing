<?php

namespace Test\Unit\BookCar;

use PHPUnit\Framework\TestCase;
use Service\BookingRepository;
use Service\CarNotFoundException;
use Service\ConfirmationNotifierInterface;
use Service\NotificationFailedException;
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


        $carStub = $this->createStub(Car::class);
        $carStub->method('isAvailable')
            ->willReturn(true);

        $carFinderStub = $this->createStub(CarFinder::class);

        $carFinderStub->method('find')
            ->willReturn(
                $carStub
            );

        $bookingRepositoryMock = $this->createMock(BookingRepository::class);
        $bookingRepositoryMock->expects($this->once())
            ->method('beginTransaction');

        $bookingRepositoryMock->expects($this->once())
            ->method('commitTransaction');

        $bookingRepositoryMock->expects($this->never())
            ->method('rollbackTransaction');

        $bookingRepositoryMock->method('bookCar')
            ->willReturn(new Booking(1, $userStub, $carStub));


        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->exactly(1))
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryMock, $notifierSpy);
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

        $bookingRepositoryMock = $this->repositoryMockWithNoCallsToTransactionMethods();
        $userDummy = $this->createStub(User::class);

        $carStub = $this->createStub(Car::class);
        $carStub->method('isAvailable')
            ->willReturn(false);

        $carFinderStub = $this->createStub(CarFinder::class);
        $carFinderStub->method('find')
            ->willReturn($carStub);

        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->never())
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryMock, $notifierSpy);

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

        $bookingRepositoryMock = $this->repositoryMockWithNoCallsToTransactionMethods();

        $userDummy = $this->createStub(User::class);

        $carFinderStub = $this->createStub(CarFinder::class);
        $carFinderStub->method('find')
            ->willThrowException(
                new CarNotFoundException()
            );

        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->never())
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryMock, $notifierSpy);
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

        $bookingRepositoryMock = $this->repositoryMockWithNoCallsToTransactionMethods();

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
        $notifierSpy->expects($this->never())
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryMock, $notifierSpy);

        $bookCarUseCase->execute($userStub, 1);
    }

    /**
     * @test
     */
    public function rollBackOnNotificationFail(){
        $this->expectException(NotificationFailedException::class);
        $carFinderStub = $this->createStub(CarFinder::class);
        $carStub = $this->createStub(Car::class);
        $userStub = $this->createStub(User::class);
        $notifierStub = $this->createStub(ConfirmationNotifierInterface::class);
        $bookingRepositoryMock = $this->createMock(BookingRepository::class);


        $userStub->method('isAnAdult')
            ->willReturn(true);

        $carFinderStub->method('find')
            ->willReturn($carStub);

        $carStub->method('getId')
            ->willReturn(1);
        $carStub->method('isAvailable')
            ->willReturn(true);

        $notifierStub->method('send')
            ->willThrowException(new NotificationFailedException());

        $bookingRepositoryMock->expects($this->once())
            ->method('beginTransaction');
        $bookingRepositoryMock->expects($this->never())
            ->method('commitTransaction');
        $bookingRepositoryMock->expects($this->once())
            ->method('rollbackTransaction');

        $bookCar = new BookCar($carFinderStub, $bookingRepositoryMock, $notifierStub);
        $bookCar->execute($userStub, 1);
    }

    private function repositoryMockWithNoCallsToTransactionMethods(): BookingRepository
    {
        $bookingRepositoryMock = $this->createMock(BookingRepository::class);
        $bookingRepositoryMock->expects($this->never())
            ->method('beginTransaction');
        $bookingRepositoryMock->expects($this->never())
            ->method('commitTransaction');
        $bookingRepositoryMock->expects($this->never())
            ->method('rollbackTransaction');

        return $bookingRepositoryMock;
    }
}