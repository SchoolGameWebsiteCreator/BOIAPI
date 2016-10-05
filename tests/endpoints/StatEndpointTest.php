<?php

use App\Models\Stat;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StatEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListStatResponseIsOk()
    {
        factory(Stat::class, 10)->create();

        $this->call('GET', '/api/v1/stat');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowStatResponseIsOk()
    {
        $stats = factory(Stat::class, 10)->create();
        $stat = $stats->get(5);

        $this->call('GET', sprintf('/api/v1/stat/%s', $stat->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListStatJsonStructure()
    {
        $stats = factory(Stat::class, 2)->create();
        $first = $stats->first();
        $second = $stats->get(1);

        $this->call('GET', '/api/v1/stat');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/stat?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/stat?page=1'),
            'data' => [
                [
                    'id' => $first->id,
                    'name' => $first->name,
                    'is_hidden' => $first->is_hidden,
                    'url' => $first->url,
                ],
                [
                    'id' => $second->id,
                    'name' => $second->name,
                    'is_hidden' => $second->is_hidden,
                    'url' => $second->url,
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testShowStatJsonStructure()
    {
        $stats = factory(Stat::class, 10)->create();
        $stat = $stats->get(4);

        $this->call('GET', sprintf('/api/v1/stat/%s', $stat->id));

        $this->seeJsonEquals([
            'id' => $stat->id,
            'name' => $stat->name,
            'is_hidden' => $stat->is_hidden,
            'url' => $stat->url,
        ]);
    }
}
