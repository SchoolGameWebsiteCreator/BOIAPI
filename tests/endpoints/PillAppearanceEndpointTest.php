<?php

use App\Models\PillAppearance;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PillAppearanceEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListPillAppearanceResponseIsOk()
    {
        factory(PillAppearance::class, 10)->create();

        $this->call('GET', '/api/v1/pill-appearance');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowPillAppearanceResponseIsOk()
    {
        $appearances = factory(PillAppearance::class, 10)->create();
        $appearance = $appearances->get(5);

        $this->call('GET', sprintf('/api/v1/pill-appearance/%s', $appearance->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListPillAppearanceJsonStructure()
    {
        $appearances = factory(PillAppearance::class, 2)->create();
        $first = $appearances->first();
        $second = $appearances->get(1);

        $this->call('GET', '/api/v1/pill-appearance');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/pill-appearance?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/pill-appearance?page=1'),
            'data' => [
                [
                    'id' => $first->id,
                    'identifier' => $first->identifier,
                    'url' => $first->url,
                    'sprite_url' => $first->spriteUrl,
                ],
                [
                    'id' => $second->id,
                    'identifier' => $second->identifier,
                    'url' => $second->url,
                    'sprite_url' => $second->spriteUrl,
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testShowPillAppearanceJsonStructure()
    {
        $appearances = factory(PillAppearance::class, 10)->create();
        $appearance = $appearances->get(4);

        $this->call('GET', sprintf('/api/v1/pill-appearance/%s', $appearance->id));

        $this->seeJsonEquals([
            'id' => $appearance->id,
            'identifier' => $appearance->identifier,
            'url' => $appearance->url,
            'sprite_url' => $appearance->spriteUrl,
        ]);
    }
}
