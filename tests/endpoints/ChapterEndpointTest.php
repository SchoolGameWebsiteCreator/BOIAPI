<?php

use App\Models\Chapter;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChapterEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListChapterResponseIsOk()
    {
        factory(Chapter::class, 10)->create();

        $this->call('GET', '/api/v1/chapter');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowChapterResponseIsOk()
    {
        $chapters = factory(Chapter::class, 10)->create();
        $chapter = $chapters->get(5);

        $this->call('GET', sprintf('/api/v1/chapter/%s', $chapter->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListChapterJsonStructure()
    {
        $chapters = factory(Chapter::class, 2)->create();
        $first = $chapters->first();
        $second = $chapters->get(1);

        $this->call('GET', '/api/v1/chapter');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/chapter?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/chapter?page=1'),
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
    public function testShowChapterJsonStructure()
    {
        $chapters = factory(Chapter::class, 10)->create();
        $chapter = $chapters->get(4);

        $this->call('GET', sprintf('/api/v1/chapter/%s', $chapter->id));

        $this->seeJsonEquals([
            'id' => $chapter->id,
            'name' => $chapter->name,
            'url' => $chapter->url,
            'environments' => $chapter->environments->jsonSerialize(),
        ]);
    }
}
