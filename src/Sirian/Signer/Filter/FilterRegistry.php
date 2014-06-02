<?php

namespace Sirian\Signer\Filter;

use Sirian\Signer\FilterNotFoundException;

class FilterRegistry
{
    /**
     * @var FilterInterface[]
     */
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->setFilters($filters);
    }

    public function setFilters($filters)
    {
        $this->filters = [];
        foreach ($filters as $filter) {
            $this->add($filter);
        }
    }

    public function add(FilterInterface $filter)
    {
        $this->filters[mb_strtolower($filter->getName())] = $filter;
        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getFilter($name)
    {
        $name = mb_strtolower($name);
        if (!$this->hasFilter($name)) {
            throw new FilterNotFoundException();
        }
        return $this->filters[$name];
    }

    public function hasFilter($name)
    {
        return isset($this->filters[mb_strtolower($name)]);
    }
}
