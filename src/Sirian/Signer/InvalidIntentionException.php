<?php

namespace Sirian\Signer;

class InvalidIntentionException extends SignerException
{
    private $expectedIntention;
    private $givenIntention;
    private $data;

    public function __construct($expectedIntention, $givenIntention, $data = [])
    {
        $this->expectedIntention = $expectedIntention;
        $this->givenIntention = $givenIntention;
        $this->data = $data;
    }

    public function getExpectedIntention()
    {
        return $this->expectedIntention;
    }

    public function getGivenIntention()
    {
        return $this->givenIntention;
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
