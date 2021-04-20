<?php

namespace Test\Unit\Promotion;

use Cassandra\Date;
use Model\Exception\NegativeDiscountException;
use Model\Exception\NegativePromotionPeriodException;
use Model\Exception\PastPeriodException;
use Model\Exception\ZeroDiscountException;
use Model\Promotion;
use PHPUnit\Framework\TestCase;

class PromotionTest extends TestCase
{
    /**
     * @test
     */
    public function validPromotionCanBeCreated(){
        $startDate = new \DateTime('tomorrow');
        $endDate = (new \DateTime('tomorrow'))->modify('+3 day');
        $discount = 20;

        $this->assertInstanceOf(Promotion::class,
            new Promotion($startDate, $endDate, $discount)
        );
    }


    /**
     * @test
     */
    public function promotionPeriodCanBeQueried(){
        $startDate = new \DateTime('tomorrow');
        $endDate = (new \DateTime('tomorrow'))->modify('+4 day');

        $promotion = new Promotion($startDate, $endDate, 20);

        $this->assertEquals($startDate, $promotion->startDate());
        $this->assertEquals($endDate, $promotion->endDate());
    }

    /**
     * @test
     */
    public function promotionDiscountCanBeQueried(){
        $startDate = new \DateTime('tomorrow');
        $endDate = (new \DateTime('tomorrow'))->modify('+4 day');
        $discount = rand(1, 99);

        $promotion = new Promotion($startDate, $endDate, $discount);

        $this->assertEquals($discount, $promotion->discount());
    }

    /**
     * @test
     */
    public function promotionPeriodCantBeNegative(){
        $this->expectException(NegativePromotionPeriodException::class);
        $startDate = (new \DateTime('tomorrow'))->modify('+5 day');
        $endDate = new \DateTime('tomorrow');
        $discount = rand(1, 99);

        new Promotion($startDate, $endDate, $discount);
    }

    /**
     * @test
     * @throws NegativePromotionPeriodException
     */
    public function promotionPeriodCantYesterday(){
        $this->expectException(PastPeriodException::class);
        $startDate = (new \DateTime('yesterday'))->modify('-5 day');
        $endDate = new \DateTime('yesterday');
        $discount = rand(1, 99);

        new Promotion($startDate, $endDate, $discount);
    }

    /**
     * @test
     * @throws NegativePromotionPeriodException
     */
    public function promotionPeriodCantTwoDaysAgo(){
        $this->expectException(PastPeriodException::class);
        $startDate = (new \DateTime('yesterday'))->modify('-5 day');
        $endDate = (new \DateTime('yesterday'))->modify('-1 day');
        $discount = rand(1, 99);

        new Promotion($startDate, $endDate, $discount);
    }

    /**
     * @test
     * @throws NegativePromotionPeriodException
     */
    public function promotionPeriodCantEndInThePast(){
        $this->expectException(PastPeriodException::class);
        $startDate = (new \DateTime('yesterday'))->modify('-5 day');
        $endDate = (new \DateTime('yesterday'));
        $discount = rand(1, 99);

        new Promotion($startDate, $endDate, $discount);
    }

    /**
     * @test
     * @throws NegativePromotionPeriodException
     */
    public function promotionPeriodCantEndInTheFarPast(){
        $this->expectException(PastPeriodException::class);
        $startDate = (new \DateTime('yesterday'))->modify('-400 day');
        $endDate = (new \DateTime('yesterday'))->modify('-100 day');

        $discount = rand(1, 99);

        new Promotion($startDate, $endDate, $discount);
    }

    /**
     * @test
     * @throws NegativePromotionPeriodException
     * @throws PastPeriodException
     */
    public function promotionDiscountCantBeNegative(){
        $this->expectException(NegativeDiscountException::class);
        $startDate = (new \DateTime('tomorrow'));
        $endDate = (new \DateTime('tomorrow'))->modify('1 day');

        $discount = rand(1 , 100)*-1;

        new Promotion($startDate, $endDate, $discount);
    }

    /**
     * @test
     * @throws NegativePromotionPeriodException
     * @throws PastPeriodException
     */
    public function promotionDiscountCantBeZero(){
        $this->expectException(ZeroDiscountException::class);
        $startDate = (new \DateTime('tomorrow'));
        $endDate = (new \DateTime('tomorrow'))->modify('1 day');

        $discount = 0;

        new Promotion($startDate, $endDate, $discount);
    }
}
