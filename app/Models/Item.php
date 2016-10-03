<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Concerns\Model\UrlAttributeTrait;
use App\Contracts\Model\ListableResourceInterface;
use App\Contracts\Model\ShowableResourceInterface;

class Item extends BaseModel implements ListableResourceInterface, ShowableResourceInterface
{
    use UrlAttributeTrait;

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $resource = 'item';

    /**
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList(Builder $query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow(Builder $query)
    {
        return $query;
    }
}
