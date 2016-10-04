<?php

use App\Models\Environment;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EnvironmentEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListEnvironmentResponseIsOk()
    {
        factory(Environment::class, 10)->create();

        $this->call('GET', '/api/v1/environment');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowEnvironmentResponseIsOk()
    {
        $environments = factory(Environment::class, 10)->create();
        $environment = $environments->get(5);

        $this->call('GET', sprintf('/api/v1/environment/%s', $environment->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListEnvironmentJsonStructure()
    {
        $environments = factory(Environment::class, 2)->create();
        $first = $environments->first();
        $second = $environments->get(1);

        $this->call('GET', '/api/v1/environment');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/environment?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/environment?page=1'),
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
    public function testShowEnvironmentJsonStructure()
    {
        $environments = factory(Environment::class, 10)->create();
        $environment = $environments->get(4);

        $this->call('GET', sprintf('/api/v1/environment/%s', $environment->id));

        $this->seeJsonEquals([
            'id' => $environment->id,
            'name' => $environment->name,
            'url' => $environment->url,
            'chapter' => $environment->chapter->jsonSerialize(),
        ]);
    }
}
