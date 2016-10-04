<?php

use App\Models\Character;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CharacterEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListCharacterResponseIsOk()
    {
        factory(Character::class, 10)->create();

        $this->call('GET', '/api/v1/character');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowCharacterResponseIsOk()
    {
        $characters = factory(Character::class, 10)->create();
        $character = $characters->get(5);

        $this->call('GET', sprintf('/api/v1/character/%s', $character->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListCharacterJsonStructure()
    {
        $characters = factory(Character::class, 2)->create();
        $first = $characters->first();
        $second = $characters->get(1);

        $this->call('GET', '/api/v1/character');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/character?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/character?page=1'),
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
    public function testShowCharacterJsonStructure()
    {
        $characters = factory(Character::class, 10)->create();
        $character = $characters->get(4);

        $this->call('GET', sprintf('/api/v1/character/%s', $character->id));

        $this->seeJsonEquals([
            'id' => $character->id,
            'name' => $character->name,
            'url' => $character->url,
            'sprite_url' => $character->spriteUrl,
        ]);
    }
}
