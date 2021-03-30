<?php declare(strict_types=1);
namespace Test\Unit\BookCar;

use PHPUnit\Framework\TestCase;
use Service\CarFinder;
use Model\Car;
use Service\CarNotFoundException;
use Service\DbConnection;
use Service\DbConnectionFailedException;

class CarFinderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnACarIfOneIsFound(){
        $dbConnectionStub = $this->createStub(DbConnection::class);
        $dbConnectionStub->method('query')
            ->willReturn([
                'id' => 1,
                'model' => 'Ibiza',
                'fuel' => 'diesel'
            ]);

        $finder = new CarFinder($dbConnectionStub);

        $car = $finder->find(1);
        $this->assertInstanceOf(Car::class, $car);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenCarIsNotFound(){
        $this->expectException(CarNotFoundException::class);

        $dbConnectionStub = $this->createStub(DbConnection::class);
        $dbConnectionStub->method('query')
            ->willReturn(null);

        $finder = new CarFinder($dbConnectionStub);
        $finder->find(1);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenDbConnectionFails(){
        $this->expectException(DbConnectionFailedException::class);

        $connectionStub = $this->createStub(DbConnection::class);
        $connectionStub->method('query')
            ->willThrowException( new DbConnectionFailedException());

        $finder = new CarFinder($connectionStub);
        $finder->find(1);
    }
}