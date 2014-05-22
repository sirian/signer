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
        $dotCount = substr_count($string, '.');
        if ($dotCount == 1) {
            $string = '1.' . $string;
        } elseif ($dotCount != 2) {
            throw new InvalidSignedStringException();
        }


        list($version, $hash, $data) = explode('.', $string, 3);
        $expectedHash = $this->signer->getSign($data);
        if ($hash !== $expectedHash) {
            throw new InvalidSignException($expectedHash, $hash);
        }

        switch ($version) {
            case 1:
                $decoded = json_decode(base64_decode($data), true);
                break;
            case 2:
                $data = str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT);
                $decoded = json_decode(gzdecode(base64_decode($data)), true);
                break;
            default:
                throw new \InvalidArgumentException();
        }


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
}
