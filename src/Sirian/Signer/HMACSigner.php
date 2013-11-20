<?php

namespace Sirian\Signer;

class HMACSigner implements SignerInterface
{
    protected $secret;
    protected $algorithm;

    public function __construct($secret, $algorithm = 'sha256')
    {
        $this->secret = $secret;
        $this->algorithm = $algorithm;
    }

    public function getSign($data)
    {
        return hash_hmac($this->algorithm, $data, $this->secret);
    }
}
