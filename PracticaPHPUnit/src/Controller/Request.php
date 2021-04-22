<?php


namespace Controller;


class Request
{

    public function __construct(array $postParams)
    {
        $this->postParams = $postParams;
    }

    public static function fromGlobals()
    {
        return new self($_POST);
    }

    public function byId(string $id)
    {
        return isset($this->postParams[$id]) ? $this->postParams[$id] : null;
    }

}