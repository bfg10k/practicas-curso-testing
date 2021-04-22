<?php

namespace Controller;

use Model\User;
use UseCase\BookCar;

class BookingController
{
    private BookCar $bookCarUseCase;

    public function __construct(BookCar $bookCarUseCase)
    {
        $this->bookCarUseCase = $bookCarUseCase;
    }

    public function bookCar(Request $request, Session $session): string
    {
        $this->bookCarUseCase->execute(
            User::proxyWithId($session->byId('userId')),
            $request->byId('carId')
        );
        return '{"errors":["Impossible to perform the Booking"]}';
    }
}