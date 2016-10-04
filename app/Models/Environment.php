<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Concerns\Model\UrlAttributeTrait;
use App\Contracts\Model\ListableResourceInterface;
use App\Contracts\Model\ShowableResourceInterface;

class Environment extends BaseModel implements ListableResourceInterface, ShowableResourceInterface
{
    use UrlAttributeTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $resource = 'environment';

    /**
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'chapter_id',
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
        return $query->with([
            'chapter',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
