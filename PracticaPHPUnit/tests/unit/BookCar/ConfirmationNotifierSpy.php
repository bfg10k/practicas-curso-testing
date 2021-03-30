<?php


namespace Test\Unit\BookCar;


use Model\Booking;
use Service\ConfirmationNotifierInterface;

class ConfirmationNotifierSpy implements ConfirmationNotifierInterface
{
    private int $counter;

    public function __construct()
    {
        $this->counter = 0;
    }

    public function send(Booking $booking): void
    {
        $this->counter++;
    }

    public function timesSendWasCalled(): int
    {
        return $this->counter;
    }
}