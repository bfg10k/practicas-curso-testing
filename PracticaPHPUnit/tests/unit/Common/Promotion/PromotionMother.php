<?php


namespace Test\Unit\Common\Promotion;


use Model\Promotion;

class PromotionMother
{
    /**
     * @return Promotion
     * @throws \Model\Exception\NegativeDiscountException
     * @throws \Model\Exception\NegativePromotionPeriodException
     * @throws \Model\Exception\PastPeriodException
     * @throws \Model\Exception\ZeroDiscountException
     */
    public static function randomValidPromotion(){
        $initialDate = (new \DateTimeImmutable('tomorrow'))->modify(rand(0, 100).' day');
        $endDate = $initialDate->modify(rand(0, 100).' day');

        return new Promotion(
            $initialDate,
            $endDate,
            rand(1,99)
        );
    }
}