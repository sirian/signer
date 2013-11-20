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
            'expires' =>  $data->getExpires() ? $data->getExpires()->getTimestamp() : 0
        ];

        $data = base64_encode(json_encode($data));

        return sprintf('%s.%s', $this->signer->getSign($data), $data);
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
