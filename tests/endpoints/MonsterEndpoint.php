<?php

use App\Models\Monster;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MonsterEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListMonsterResponseIsOk()
    {
        factory(Monster::class, 10)->create();

        $this->call('GET', '/api/v1/monster');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowMonsterResponseIsOk()
    {
        $monsters = factory(Monster::class, 10)->create();
        $monster = $monsters->get(5);

        $this->call('GET', sprintf('/api/v1/monster/%s', $monster->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListMonsterJsonStructure()
    {
        $monsters = factory(Monster::class, 2)->create();
        $first = $monsters->first();
        $second = $monsters->get(1);

        $this->call('GET', '/api/v1/monster');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/monster?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/monster?page=1'),
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
    public function testShowMonsterJsonStructure()
    {
        $monsters = factory(Monster::class, 10)->create();
        $monster = $monsters->get(4);

        $this->call('GET', sprintf('/api/v1/monster/%s', $monster->id));

        $this->seeJsonEquals([
            'id' => $monster->id,
            'name' => $monster->name,
            'url' => $monster->url,
            'sprite_url' => $monster->spriteUrl,
        ]);
    }
}
