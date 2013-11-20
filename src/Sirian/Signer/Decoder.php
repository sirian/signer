<?php

namespace Sirian\Signer;

class Decoder
{
    /**
     * @var SignerInterface
     */
    protected  $signer;

    public function __construct(SignerInterface $signer)
    {
        $this->signer = $signer;
    }

    public function decode($string, $intention)
    {
        if (false === strpos($string, '.')) {
            throw new InvalidSignedStringException();
        }

        list($hash, $data) = explode('.', $string);
        $expectedHash = $this->signer->getSign($data);
        if ($hash !== $expectedHash) {
            throw new InvalidSignException($expectedHash, $hash);
        }

        $decoded = json_decode(base64_decode($data), true);

        if (!isset($decoded['intention']) || $decoded['intention'] !== $intention) {
            throw new InvalidSignException($intention, $decoded['intention']);
        }

        $now = new \DateTime();
        if (null !== $decoded['expires'] && $decoded['expires'] < $now->getTimestamp()) {
            throw new ExpiredException();
        }

        $data = new Data();


        $data
            ->setIntention($decoded['intention'])
            ->setData($decoded['data'])
        ;

        if ($decoded['expires']) {
            $expires = new \DateTime();
            $expires->setTimestamp($decoded['expires']);
            $data->setExpires($expires);
        }

        return $data;
    }
}
