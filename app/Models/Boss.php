<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Concerns\Model\UrlAttributeTrait;
use App\Contracts\Model\ListableResourceInterface;
use App\Contracts\Model\ShowableResourceInterface;

class Boss extends BaseModel implements ListableResourceInterface, ShowableResourceInterface
{
    use UrlAttributeTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $resource = 'boss';

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

    /**
     * @return string
     */
    public function getSpriteUrlAttribute()
    {
        return url(
            sprintf(
                'img/sprites/bosses/%s.png',
                $this->attributes['id']
            )
        );
    }
}
