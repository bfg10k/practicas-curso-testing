<?php declare(strict_types=1);

namespace Model\Exception;

use Exception;

class NegativePromotionPeriodException extends Exception
{

    /**
     * NegativePromotionPeriodException constructor.
     */
    public function __construct()
    {
    }
}