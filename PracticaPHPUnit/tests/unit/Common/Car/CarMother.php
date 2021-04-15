<?php

namespace Test\Unit\Common\Car;

use Model\Car;

class CarMother
{
    public static function generateAvailable(): Car{
        return new Car(1, 'ibiza', 'diesel');
    }

    public static function generateUnavailable()
    {
        return new Car(1, 'ibiza', 'diesel', false);
    }

    public static function withId()
    {
        return new Car(1, 'ibiza', 'diesel');
    }
}