<?php declare(strict_types=1);

namespace Test\Unit\Promotion;

use DateTime;
use Model\Exception\NegativePromotionPeriodException;
use Model\Exception\PastPeriodException;
use Model\Period;
use Model\Promotion;
use PHPUnit\Framework\TestCase;
use Service\PromotionRepository;
use Test\Unit\Promotion\Doubles\PromotionRepositoryMock;
use UseCase\CreatePromotion;

class CreatePromotionTest extends TestCase
{
    /** @test */
    public function validPromotionCanBeCreated() {
        $promotionRepositoryMock = new PromotionRepositoryMock();

        $useCase = new CreatePromotion($promotionRepositoryMock);
        $startDate = new DateTime('tomorrow');
        $endDate = (new DateTime('tomorrow'))->modify('5 day');

        $discount = 5;

        $promotion = $useCase->execute($startDate, $endDate, $discount);

        $this->assertInstanceOf(Promotion::class, $promotion);
        $this->assertEquals(1, $promotionRepositoryMock->timesCalled());
    }

    /** @test */
    public function cantCreatePromotionWithNegativePeriod(){
        $this->expectException(NegativePromotionPeriodException::class);
        $useCase = new CreatePromotion(
            $this->createStub(PromotionRepository::class)
        );

        $startDate = new DateTime('tomorrow');
        $endDate = (new DateTime('tomorrow'))->modify('-5 day');
        $discount = 5;

        $useCase->execute($startDate, $endDate, $discount);
    }

    /** @test */
    public function cantCreatePromotionWithPastPeriod() {
        $this->expectException(PastPeriodException::class);

        $useCase = new CreatePromotion(
            $this->createStub(PromotionRepository::class)
        );

        $startDate = (new DateTime())->modify('-10 day');
        $endDate = (new DateTime())->modify('-3 day');
        $discount = 5;

        $useCase->execute($startDate, $endDate, $discount);

    }

}