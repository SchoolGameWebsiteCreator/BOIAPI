<?php

namespace App\Contracts\Model;

use Illuminate\Database\Eloquent\Builder;

interface ShowableResourceInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow(Builder $query);
}
