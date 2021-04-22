<?php

namespace Test\Unit\Promotion\Doubles;

use Model\Promotion;
use Service\PromotionRepository;

class PromotionRepositoryMock extends PromotionRepository
{
    private int $timesCalled=0;

    public function save(Promotion $promotion): Promotion {
        $this->timesCalled++;
        return $promotion;
    }

    public function timesCalled(): int{
        return $this->timesCalled;
    }
}