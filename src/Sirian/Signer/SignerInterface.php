<?php

namespace Sirian\Signer;

interface SignerInterface
{
    public function getSign($data);
}
