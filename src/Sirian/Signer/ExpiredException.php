<?php

namespace Sirian\Signer;

class ExpiredException extends SignException
{
    private $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

}
