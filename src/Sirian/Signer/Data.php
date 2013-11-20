<?php

namespace Sirian\Signer;

class Data
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $intention;

    /**
     * @var \DateTime
     */
    protected $expires;

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getIntention()
    {
        return $this->intention;
    }

    public function setIntention($intention)
    {
        $this->intention = $intention;
        return $this;
    }

    public function getExpires()
    {
        return $this->expires;
    }

    public function setExpires(\DateTime $expires = null)
    {
        $this->expires = $expires;
        return $this;
    }
}
