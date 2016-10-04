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
            'api.character.index' => url('/api/v1/character'),
            'api.character.show' => url('/api/v1/character/{character}'),
            'api.item.index' => url('/api/v1/item'),
            'api.item.show' => url('/api/v1/item/{item}'),
            'api.monster.index' => url('/api/v1/monster'),
            'api.monster.show' => url('/api/v1/monster/{monster}'),
        ];
    }
}
