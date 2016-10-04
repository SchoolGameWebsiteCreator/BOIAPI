<?php

use App\Models\Pickup;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PickupEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListPickupResponseIsOk()
    {
        factory(Pickup::class, 10)->create();

        $this->call('GET', '/api/v1/pickup');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowPickupResponseIsOk()
    {
        $pickups = factory(Pickup::class, 10)->create();
        $pickup = $pickups->get(5);

        $this->call('GET', sprintf('/api/v1/pickup/%s', $pickup->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListPickupJsonStructure()
    {
        $pickups = factory(Pickup::class, 2)->create();
        $first = $pickups->first();
        $second = $pickups->get(1);

        $this->call('GET', '/api/v1/pickup');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/pickup?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/pickup?page=1'),
            'data' => [
                [
                    'id' => $first->id,
                    'name' => $first->name,
                    'url' => $first->url,
                    'sprite_url' => $first->spriteUrl,
                ],
                [
                    'id' => $second->id,
                    'name' => $second->name,
                    'url' => $second->url,
                    'sprite_url' => $second->spriteUrl,
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testShowPickupJsonStructure()
    {
        $pickups = factory(Pickup::class, 10)->create();
        $pickup = $pickups->get(4);

        $this->call('GET', sprintf('/api/v1/pickup/%s', $pickup->id));

        $this->seeJsonEquals([
            'id' => $pickup->id,
            'name' => $pickup->name,
            'url' => $pickup->url,
            'sprite_url' => $pickup->spriteUrl,
            'pickup_type' => $pickup->pickupType->jsonSerialize(),
        ]);
    }
}
