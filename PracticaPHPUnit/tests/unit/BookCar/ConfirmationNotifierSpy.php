<?php declare(strict_types=1);


namespace Test\Unit\BookCar;


use Model\Booking;
use Service\ConfirmationNotifierInterface;

class ConfirmationNotifierSpy implements ConfirmationNotifierInterface
{

    private int $timesCalled = 0;

    public function send(Booking $booking): void
    {
        $this->timesCalled++;
    }

    public function timesSendWasCalled(){
        return $this->timesCalled;
    }
}