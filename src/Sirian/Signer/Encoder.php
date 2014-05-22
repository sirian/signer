<?php

namespace Sirian\Signer;

class Encoder
{
    /**
     * @var SignerInterface
     */
    protected $signer;

    public function __construct(SignerInterface $signer)
    {
        $this->signer = $signer;
    }

    public function encode(Data $data)
    {
        $data = [
            'data' => $data->getData(),
            'intention' => $data->getIntention(),
            'expires' =>  $data->getExpires() ? $data->getExpires()->getTimestamp() : null
        ];

        $version = 2;
        $data = base64_encode(gzencode(json_encode($data, JSON_UNESCAPED_UNICODE)));
        $data = rtrim(strtr($data, '+/', '-_'), '=');

        return sprintf('%s.%s.%s', $version, $this->signer->getSign($data), $data);
    }

    public function getSigner()
    {
        return $this->signer;
    }

    public function setSigner($signer)
    {
        $this->signer = $signer;
        return $this;
    }
}
