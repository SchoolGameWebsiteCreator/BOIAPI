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
            'api.item.index' => url('/api/v1/item'),
            'api.item.show' => url('/api/v1/item/{item}'),
        ];
    }
}
