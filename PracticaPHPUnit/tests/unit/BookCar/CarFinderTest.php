<?php declare(strict_types=1);

namespace Test\Unit\BookCar;

use Model\Car;
use PHPUnit\Framework\TestCase;
use Service\CarFinder;
use Service\DbConnection;

class CarFinderTest extends TestCase
{
    /** @test */
    public function shouldReturnACarIfOneIsFound(){
        $dbConnectionStub= $this->createStub(DbConnection::class);
        $dbConnectionStub->method('query')
            ->willReturn(
                [
                    'id'=> 1,
                    'model' => 'Ibiza',
                    'fuel' => 'diesel'
                ]
            );

        $finder = new CarFinder($dbConnectionStub);
        $car = $finder->find(1);
        $this->assertInstanceOf(Car::class, $car);
    }
}