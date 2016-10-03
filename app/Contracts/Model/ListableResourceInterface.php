<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Builder;

interface ListableResourceInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList(Builder $query);
}
