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
            'api.item.index' => url('/api/v1/item'),
            'api.item.show' => url('/api/v1/item/{item}'),
        ];
    }
}
