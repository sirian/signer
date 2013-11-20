<?php

namespace Sirian\Signer;

class InvalidIntentionException extends SignException
{
    private $expectedIntention;
    private $givenIntention;

    public function __construct($expectedIntention, $givenIntention)
    {
        $this->expectedIntention = $expectedIntention;
        $this->givenIntention = $givenIntention;
    }

    public function getExpectedIntention()
    {
        return $this->expectedIntention;
    }

    public function getGivenIntention()
    {
        return $this->givenIntention;
    }
}
