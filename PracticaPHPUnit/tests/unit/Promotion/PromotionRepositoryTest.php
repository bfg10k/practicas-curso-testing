<?php

namespace Test\Unit\Promotion;

use Model\Promotion;
use PHPUnit\Framework\TestCase;
use Service\PromotionRepository;
use Test\Unit\Common\Promotion\PromotionMother;

class PromotionRepositoryTest extends TestCase
{
    /** @test */
    public function promotionCanBeSaved(){
        $repository = new PromotionRepository();
        $promotion = $repository->save(PromotionMother::randomValidPromotion());

        $this->assertInstanceOf(Promotion::class, $promotion);
    }
}