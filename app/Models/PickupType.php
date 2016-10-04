<?php

namespace App\Models;

class PickupType extends BaseModel
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pickups()
    {
        return $this->hasMany(Pickup::class);
    }
}
