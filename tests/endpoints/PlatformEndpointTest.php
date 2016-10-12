<?php

use App\Models\Platform;
use App\Models\Installment;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PlatformEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListPlatformResponseIsOk()
    {
        factory(Platform::class, 10)->create();

        $this->call('GET', '/api/v1/platform');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowPlatformResponseIsOk()
    {
        $platforms = factory(Platform::class, 10)->create();
        $platform = $platforms->get(5);

        $this->call('GET', sprintf('/api/v1/platform/%s', $platform->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListPlatformJsonStructure()
    {
        $platforms = factory(Platform::class, 2)->create();
        $first = $platforms->first();
        $second = $platforms->get(1);

        $this->call('GET', '/api/v1/platform');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/platform?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/platform?page=1'),
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
    public function testShowPlatformJsonStructure()
    {
        $installments = factory(Installment::class, 3)->create();

        $platforms = factory(Platform::class, 10)->create();
        $platform = $platforms->get(4);
        $platform->installments()->attach($installments->pluck('id')->toArray());

        $this->call('GET', sprintf('/api/v1/platform/%s', $platform->id));

        $this->seeJsonEquals([
            'id' => $platform->id,
            'name' => $platform->name,
            'url' => $platform->url,
            'installments' => $platform->installments->jsonSerialize(),
        ]);
    }
}
