<?php

namespace App\Concerns\Model;

use ErrorException;

trait SpriteUrlAttributeTrait
{
    /**
     * Return a sprite URL based on the model resource name.
     *
     * Checks the path exists; if not, returns null.
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

        $path = sprintf(
            'img/sprites/' . str_plural($this->resource, 2) . '/%s.png',
            $this->attributes['id']
        );

        if (is_readable(public_path($path))) {
            return url($path);
        }
        return null;
    }
}
