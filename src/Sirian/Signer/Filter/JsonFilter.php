<?php

namespace Sirian\Signer\Filter;

class JsonFilter implements FilterInterface
{
    public function encode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function decode($data)
    {
        return json_decode($data, true);
    }

    public function getName()
    {
        return 'json';
    }
}
