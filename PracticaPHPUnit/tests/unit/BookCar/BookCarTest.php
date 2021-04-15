<?php

namespace Test\Unit\BookCar;

use PHPUnit\Framework\TestCase;
use Service\BookingRepository;
use Service\CarNotFoundException;
use Service\ConfirmationNotifierInterface;
use Service\NotificationFailedException;
use Test\Unit\Common\Car\CarMother;
use Test\Unit\Common\User\UserMother;
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
        $user = UserMother::generateAdult();

        $car = CarMother::generateAvailable();

        $carFinderStub = $this->createStub(CarFinder::class);

        $carFinderStub->method('find')
            ->willReturn(
                $car
            );

        $bookingRepositoryMock = $this->createMock(BookingRepository::class);
        $bookingRepositoryMock->expects($this->once())
            ->method('beginTransaction');

        $bookingRepositoryMock->expects($this->once())
            ->method('commitTransaction');

        $bookingRepositoryMock->expects($this->never())
            ->method('rollbackTransaction');

        $bookingRepositoryMock->method('bookCar')
            ->willReturn(new Booking(1, $user, $car));


        $notifierSpy = $this->createMock(ConfirmationNotifierInterface::class);
        $notifierSpy->expects($this->exactly(1))
            ->method('send');

        $bookCarUseCase = new BookCar($carFinderStub, $bookingRepositoryMock, $notifierSpy);
        $booking = $bookCarUseCase->execute(
            $user,
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

        $car = CarMother::generateUnavailable();

        $carFinderStub = $this->createStub(CarFinder::class);
        $carFinderStub->method('find')
            ->willReturn($car);

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
        $availableCar = CarMother::generateAvailable();

        $carFinderStub = $this->createStub(CarFinder::class);

        $userStub->method('isAnAdult')
            ->willReturn(false);

        $carFinderStub->method('find')
            ->willReturn($availableCar);

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
        $availableCar = CarMother::generateAvailable();
        $userStub = $this->createStub(User::class);
        $notifierStub = $this->createStub(ConfirmationNotifierInterface::class);
        $bookingRepositoryMock = $this->createMock(BookingRepository::class);


        $userStub->method('isAnAdult')
            ->willReturn(true);

        $carFinderStub->method('find')
            ->willReturn($availableCar);

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