<?php

namespace Service;

use Model\Promotion;

class PromotionRepository
{
    public function save(Promotion $promotion): Promotion{
        return $promotion;
    }
}