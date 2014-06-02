<?php

namespace Sirian\Signer\Filter;

class GzFilter implements FilterInterface
{
    public function encode($data)
    {
        return gzencode($data);
    }

    public function decode($data)
    {
        return gzdecode($data);
    }

    public function getName()
    {
        return 'gz';
    }
}
