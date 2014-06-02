<?php

namespace Sirian\Signer\Filter;

interface FilterInterface
{
    public function encode($data);

    public function decode($data);

    public function getName();
}
