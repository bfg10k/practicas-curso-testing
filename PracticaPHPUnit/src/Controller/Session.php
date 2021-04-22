<?php


namespace Controller;


class Session
{
    private array $sessionParams;

    public function __construct(array $sessionParams)
    {
        $this->sessionParams = $sessionParams;
    }

    public static function fromGlobals() {
        return new self($_SESSION);
    }

    public function byId(string $id)
    {
        return $this->sessionParams[$id];
    }
}