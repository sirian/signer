<?php

namespace Sirian\Signer\Filter;

use Sirian\Signer\InvalidSignedStringException;

class FilterChain implements FilterInterface
{
    private $registry;
    private $encodeFilterChain;

    public function __construct(FilterRegistry $registry, array $encodeFilterChain)
    {
        $this->registry = $registry;
        $this->encodeFilterChain = $encodeFilterChain;
    }

    public function encode($data)
    {

        foreach ($this->encodeFilterChain as $filter) {
            if (!$filter instanceof FilterInterface) {
                $filter = $this->registry->getFilter($filter);
            }
            $data = $filter->getName() . '.' . $filter->encode($data);
        }
        return count($this->encodeFilterChain) . '.' . $data;
    }

    public function decode($data)
    {
        if (false === strpos($data, '.')) {
            throw new InvalidSignedStringException();
        }

        list($count, $data) = explode('.', $data, 2);
        for ($i = 0; $i < $count; $i++) {
            if (false === strpos($data, '.')) {
                throw new InvalidSignedStringException();
            }
            list ($filterName, $data) = explode('.', $data, 2);

            $filter = $this->registry->getFilter($filterName);

            $data = $filter->decode($data);
        }

        return $data;
    }

    public function getName()
    {
        return 'chain';
    }
}
