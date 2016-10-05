<?php

namespace App\Http\Controllers\Api;

class IndexController
{
    /**
     * API directory.
     * 
     * @return array
     */
    public function index()
    {
        return [
            'api.boss.index' => url('/api/v1/boss'),
            'api.boss.show' => url('/api/v1/boss/{boss}'),
            'api.chapter.index' => url('/api/v1/chapter'),
            'api.chapter.show' => url('/api/v1/chapter/{chapter}'),
            'api.character.index' => url('/api/v1/character'),
            'api.character.show' => url('/api/v1/character/{character}'),
            'api.environment.index' => url('/api/v1/environment'),
            'api.environment.show' => url('/api/v1/environment/{environment}'),
            'api.installment.index' => url('/api/v1/installment'),
            'api.installment.show' => url('/api/v1/installment/{installment}'),
            'api.item.index' => url('/api/v1/item'),
            'api.item.show' => url('/api/v1/item/{item}'),
            'api.monster.index' => url('/api/v1/monster'),
            'api.monster.show' => url('/api/v1/monster/{monster}'),
            'api.pickup.index' => url('/api/v1/pickup'),
            'api.pickup.show' => url('/api/v1/pickup/{pickup}'),
            'api.pill-appearance.index' => url('/api/v1/pill-appearance'),
            'api.pill-appearance.show' => url('/api/v1/pill-appearance/{pill-appearance}'),
            'api.stat.index' => url('/api/v1/stat'),
            'api.stat.show' => url('/api/v1/stat/{stat}'),
        ];
    }
}
