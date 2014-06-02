<?php

namespace Sirian\Signer\Filter;

class Base64Filter implements FilterInterface
{
    public function encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public function getName()
    {
        return 'base64';
    }
}
