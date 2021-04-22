<?php


namespace Model;


use DateTime;
use DateTimeInterface;
use Model\Exception\NegativePromotionPeriodException;
use Model\Exception\PastPeriodException;

class Period
{
    private DateTimeInterface $startDate;
    private DateTimeInterface $endDate;


    /**
     * @throws NegativePromotionPeriodException
     * @throws PastPeriodException
     */
    public function __construct(DateTimeInterface $startDate, DateTimeInterface $endDate)
    {
        if($endDate < $startDate){
            throw new NegativePromotionPeriodException();
        }

        if($endDate < new DateTime()){
            throw new PastPeriodException();
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function startDate(): DateTimeInterface
    {
        return $this->startDate;
    }

    public function endDate(): DateTimeInterface
    {
        return $this->endDate;
    }
}