<?php


namespace Model;


use DateTime;
use Model\Exception\NegativeDiscountException;
use Model\Exception\NegativePromotionPeriodException;
use Model\Exception\PastPeriodException;
use Model\Exception\ZeroDiscountException;

class Promotion
{
    private Period $period;
    private Discount $discount;

    /**
     * @throws NegativePromotionPeriodException
     * @throws PastPeriodException
     * @throws NegativeDiscountException
     * @throws ZeroDiscountException
     */
    public function __construct(\DateTimeInterface $startDate, \DateTimeInterface $endDate, int $discount)
    {
        $this->period = new Period($startDate, $endDate);
        $this->discount = new Discount($discount);
    }

    public function startDate(): \DateTimeInterface
    {
        return $this->period->startDate();
    }

    public function endDate(): \DateTimeInterface
    {
        return $this->period->endDate();
    }

    public function discount(): int
    {
        return $this->discount->percentage();
    }
}