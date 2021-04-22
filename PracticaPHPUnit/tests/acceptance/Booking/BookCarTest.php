<?php

namespace acceptance\Booking;

use Controller\BookingController;
use Controller\Request;
use Controller\Session;
use PHPUnit\Framework\TestCase;

class BookCarTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $_POST['carId'] = 1;
        $_SESSION['userId'] = 1;
    }

    /** @test */
    public function asAUserICanBookAGasolineCarAndGetAnActivePromotion(){
        $controller = new BookingController();

        $request = Request::fromGlobals();
        $session = Session::fromGlobals();

        $bookingResult = $controller->bookCar($request, $session);

        $this->assertJson($bookingResult);
        $this->assertJsonStringEqualsJsonString(
            $bookingResult,
            json_encode(
            [
                "bookingId" => 1,
                "car" => [
                    "carId" => $request->byId('carId')
                ],
                "user" => [
                    "userId" => $session->byId('userId')
                ],
                "promotion"=> [
                    "promotionId" => 1
                ]
            ])
        );
    }

}