<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        // // sample method utk mencari by request
        // if ($this->request->has('by')) {
        //     $this->by($this->request->by);
        // }

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;

    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
        // return $this->request->intersect($this->filters);
    }
}
