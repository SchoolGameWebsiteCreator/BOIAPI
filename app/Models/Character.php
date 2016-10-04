<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Concerns\Model\UrlAttributeTrait;
use App\Concerns\Model\SpriteUrlAttributeTrait;
use App\Contracts\Model\ListableResourceInterface;
use App\Contracts\Model\ShowableResourceInterface;

class Character extends BaseModel implements ListableResourceInterface, ShowableResourceInterface
{
    use UrlAttributeTrait;
    use SpriteUrlAttributeTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $resource = 'character';

    /**
     * @var array
     */
    protected $appends = [
        'url',
        'sprite_url',
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
