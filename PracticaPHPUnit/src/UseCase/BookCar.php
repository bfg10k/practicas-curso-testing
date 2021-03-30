<?php

namespace UseCase;

use Service\BookingRepository;
use Service\CarNotFoundException;
use Service\ConfirmationNotifierInterface;
use Service\DbConnection;
use Service\CarFinder;
use Model\User;
use Model\Car;
use Model\Booking;
use Service\DbConnectionFailedException;
use Service\InsertException;
use Service\NotificationFailedException;

class BookCar
{

    private CarFinder $carFinder;
    private ConfirmationNotifierInterface $notifier;
    private BookingRepository $bookingRepository;

    public function __construct(
        CarFinder $carFinder,
        BookingRepository $bookingRepository,
        ConfirmationNotifierInterface $notifier
    ) {
        $this->carFinder = $carFinder;
        $this->notifier = $notifier;
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * @throws CarNotAvailableException
     * @throws CarNotFoundException
     * @throws DbConnectionFailedException
     * @throws InsertException
     * @throws MinorsCannotBookCarsException
     */
    public function execute(User $user, int $carId): Booking
    {
        $car = $this->carFinder->find($carId);

        if (!$car->isAvailable()) {
            throw new CarNotAvailableException();
        }

        if (!$user->isAnAdult()) {
            throw new MinorsCannotBookCarsException();
        }


        $this->bookingRepository->beginTransaction();
        try {
            $booking = $this->bookingRepository->bookCar($user, $car);
            $this->notifier->send($booking);
            $this->bookingRepository->commitTransaction();
        } catch (NotificationFailedException | InsertException $exception) {
            $this->bookingRepository->rollBackTransaction();
            throw $exception;
        }

        return $booking;
    }
}
