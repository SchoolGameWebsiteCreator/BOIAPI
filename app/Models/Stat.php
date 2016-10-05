<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Concerns\Model\UrlAttributeTrait;
use App\Contracts\Model\ListableResourceInterface;
use App\Contracts\Model\ShowableResourceInterface;

class Stat extends BaseModel implements ListableResourceInterface, ShowableResourceInterface
{
    use UrlAttributeTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $resource = 'stat';

    /**
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_hidden' => 'bool',
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
