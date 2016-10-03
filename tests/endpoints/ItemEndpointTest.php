<?php

use App\Models\Item;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ItemEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListItemResponseIsOk()
    {
        factory(Item::class, 10)->create();

        $this->call('GET', '/api/v1/item');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowItemResponseIsOk()
    {
        $items = factory(Item::class, 10)->create();
        $item = $items->get(5);

        $this->call('GET', sprintf('/api/v1/item/%s', $item->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListItemJsonStructure()
    {
        $items = factory(Item::class, 2)->create();
        $first = $items->first();
        $second = $items->get(1);

        $this->call('GET', '/api/v1/item');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/item?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/item?page=1'),
            'data' => [
                [
                    'id' => $first->id,
                    'name' => $first->name,
                    'url' => $first->url,
                ],
                [
                    'id' => $second->id,
                    'name' => $second->name,
                    'url' => $second->url,
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testShowItemJsonStructure()
    {
        $items = factory(Item::class, 10)->create();
        $item = $items->get(4);

        $this->call('GET', sprintf('/api/v1/item/%s', $item->id));

        $this->seeJsonEquals([
            'id' => $item->id,
            'name' => $item->name,
            'url' => $item->url,
        ]);
    }
}
