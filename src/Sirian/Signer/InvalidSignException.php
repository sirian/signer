<?php

namespace Sirian\Signer;

class InvalidSignException extends SignException
{
    private $expectedSign;
    private $givenSign;

    public function __construct($expectedIntention, $givenIntention)
    {
        $this->expectedSign = $expectedIntention;
        $this->givenSign = $givenIntention;
    }

    public function getExpectedSign()
    {
        return $this->expectedSign;
    }

    public function getGivenSign()
    {
        return $this->givenSign;
    }
}
