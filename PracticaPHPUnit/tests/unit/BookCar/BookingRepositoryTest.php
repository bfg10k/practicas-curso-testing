<?php

namespace Test\Unit\BookCar;


use Model\Booking;
use PHPUnit\Framework\TestCase;
use Service\BookingRepository;
use Service\DbConnection;
use Test\Unit\Common\Car\CarMother;
use Test\Unit\Common\User\UserMother;

class BookingRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function bookingGetsCreated(){
        $user = UserMother::withId();
        $car = CarMother::withId();

        $connectionStub = $this->createStub(DbConnection::class);
        $connectionStub->method('insert')
            ->willReturn(1);

        $bookingRepository = new BookingRepository($connectionStub);
        $booking = $bookingRepository->bookCar($user, $car);

        $this->assertInstanceOf(Booking::class, $booking);
    }
}