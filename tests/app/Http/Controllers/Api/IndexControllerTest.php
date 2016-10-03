<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testIndexResponseIsOk()
    {
        $this->call('GET', '/api/v1');

        $this->assertResponseOk();
    }
}
