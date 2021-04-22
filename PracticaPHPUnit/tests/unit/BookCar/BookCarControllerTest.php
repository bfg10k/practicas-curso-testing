<?php


namespace Test\Unit\BookCar;


use Controller\BookingController;
use Controller\Request;
use Controller\Session;
use PHPUnit\Framework\TestCase;
use Test\Unit\BookCar\Doubles\BookCarMock;
use UseCase\BookCar;

class BookCarControllerTest extends TestCase
{

    /** @test */
    public function adultsCanBookAvailableCars(){
        $bookCarUseCaseMock = new BookCarMock();
        $controller = new BookingController($bookCarUseCaseMock);

        $request = new Request(['carId'=> 1]);
        $session = new Session(['userId'=> 1]);

        $booking = $controller->bookCar($request, $session);

        $this->assertEquals(1, $bookCarUseCaseMock->timesCalled());
    }
}