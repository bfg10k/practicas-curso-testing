<?php declare(strict_types=1);

namespace Service;

use Model\Booking;

interface ConfirmationNotifierInterface
{
    public function send(Booking $booking): void;
}