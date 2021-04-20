<?php


namespace Model;


use DateTime;
use Model\Exception\NegativePromotionPeriodException;
use Model\Exception\PastPeriodException;

class Period
{
    private DateTime $startDate;
    private DateTime $endDate;


    /**
     * @throws NegativePromotionPeriodException
     * @throws PastPeriodException
     */
    public function __construct(DateTime $startDate, DateTime $endDate)
    {
        if($endDate < new DateTime()){
            throw new PastPeriodException();
        }

        if($endDate < $startDate){
            throw new NegativePromotionPeriodException();
        }
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function startDate(): DateTime
    {
        return $this->startDate;
    }

    public function endDate(): DateTime
    {
        return $this->endDate;
    }
}