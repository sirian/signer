<?php

namespace Sirian\Signer;

use Sirian\Signer\Filter\FilterInterface;

class Manager
{
    private $algorithm;
    private $secret;
    private $filter;

    public function __construct($algorithm, $secret, FilterInterface $filter)
    {
        $this->algorithm = $algorithm;
        $this->secret = $secret;
        $this->filter = $filter;
    }

    public function encode(Data $data)
    {
        $data = [
            'data' => $data->getData(),
            'intention' => $data->getIntention(),
            'expires' =>  $data->getExpires() ? $data->getExpires()->getTimestamp() : null
        ];

        $data = $this->filter->encode($data);

        return sprintf('%s.%s.%s', $this->algorithm, $this->getSign($data, $this->algorithm), $data);
    }

    public function decode($string, $intention)
    {
        $dotCount = substr_count($string, '.');
        if ($dotCount < 2) {
            throw new InvalidSignedStringException();
        }


        list($algorithm, $hash, $data) = explode('.', $string, 3);
        $expectedHash = $this->getSign($data, $algorithm);

        if ($hash !== $expectedHash) {
            throw new InvalidSignerException();
        }

        $decoded = $this->filter->decode($data);


        if (!isset($decoded['intention']) || $decoded['intention'] !== $intention) {
            $exception = new InvalidIntentionException($intention, $decoded['intention']);
            $exception->setData($decoded);
            throw $exception;
        }

        $now = new \DateTime();
        if (null !== $decoded['expires'] && $decoded['expires'] < $now->getTimestamp()) {
            $exception = new ExpiredException();
            $exception->setData($decoded);
            throw $exception;
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

    public function getSign($data, $algorithm)
    {
        return hash_hmac($algorithm, $data, $this->secret);
    }
}
