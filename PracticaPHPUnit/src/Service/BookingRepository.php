<?php declare(strict_types=1);

namespace Service;

use Model\Booking;
use Model\Car;
use Model\User;

class BookingRepository
{
    /**
     * @var DbConnection
     */
    private DbConnection $connection;

    public function __construct(DbConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws InsertException
     */
    public function bookCar(User $user, Car $car): Booking
    {
        $bookingId = $this->connection->insert(
            'INSERT INTO bookings (userId, carId) VALUES('.$user->getId().', '.
            $car->getId().')'
        );

        return new Booking($bookingId, $user, $car);
    }

    public function beginTransaction(): void
    {
    }

    public function commitTransaction(): void
    {
    }

    public function rollBackTransaction(): void
    {
    }
}