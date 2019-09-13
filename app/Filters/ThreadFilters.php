<?php

namespace App\Filters;

use App\Filters\Filters;
use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];

    // filter the query by a given username
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    // filter the query according to most popular threads
    public function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

}
