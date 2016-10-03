<?php

use App\Models\Boss;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BossEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListBossResponseIsOk()
    {
        factory(Boss::class, 10)->create();

        $this->call('GET', '/api/v1/boss');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowBossResponseIsOk()
    {
        $bosses = factory(Boss::class, 10)->create();
        $boss = $bosses->get(5);

        $this->call('GET', sprintf('/api/v1/boss/%s', $boss->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListBossJsonStructure()
    {
        $bosses = factory(Boss::class, 2)->create();
        $first = $bosses->first();
        $second = $bosses->get(1);

        $this->call('GET', '/api/v1/boss');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/boss?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/boss?page=1'),
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
    public function testShowBossJsonStructure()
    {
        $bosses = factory(Boss::class, 10)->create();
        $boss = $bosses->get(4);

        $this->call('GET', sprintf('/api/v1/boss/%s', $boss->id));

        $this->seeJsonEquals([
            'id' => $boss->id,
            'name' => $boss->name,
            'url' => $boss->url,
            'sprite_url' => $boss->spriteUrl,
        ]);
    }
}
