<?php


namespace Model;


use Model\Exception\NegativeDiscountException;
use Model\Exception\ZeroDiscountException;

class Discount
{
    private int $percentage;

    /**
     * @throws NegativeDiscountException
     * @throws ZeroDiscountException
     */
    public function __construct(int $percentage)
    {
        if($percentage < 0){
            throw new NegativeDiscountException();
        }

        if($percentage === 0){
            throw new ZeroDiscountException();
        }

        $this->percentage = $percentage;
    }

    public function percentage()
    {
        return $this->percentage;
    }
}