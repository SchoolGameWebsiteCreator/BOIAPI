<?php

namespace App\Concerns\Model;

use ErrorException;

trait SpriteUrlAttributeTrait
{
    /**
     * Return a sprite URL based on the model resource name.
     *
     * @throws \ErrorException
     * @return string
     */
    public function getSpriteUrlAttribute()
    {
        if (! property_exists($this, 'resource')) {
            throw new ErrorException(
                sprintf("Missing property 'resource' in %s required for %s", __CLASS__, __METHOD__)
            );
        }

        return url(
            sprintf(
                'img/sprites/' . str_plural($this->resource, 2) . '/%s.png',
                $this->attributes['id']
            )
        );
    }
}
