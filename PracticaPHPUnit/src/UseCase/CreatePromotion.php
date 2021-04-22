<?php


namespace UseCase;


use Model\Promotion;
use Service\PromotionRepository;

class CreatePromotion
{
    private PromotionRepository $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    /**
     * @throws \Model\Exception\NegativeDiscountException
     * @throws \Model\Exception\NegativePromotionPeriodException
     * @throws \Model\Exception\PastPeriodException
     * @throws \Model\Exception\ZeroDiscountException
     */
    public function execute(\DateTime $startDate, \DateTime $endDate, int $discount)
    {
        return $this->promotionRepository->save(new Promotion($startDate, $endDate, $discount));
    }
}