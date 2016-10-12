<?php

use App\Models\Platform;
use App\Models\Installment;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class InstallmentEndpointTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListInstallmentResponseIsOk()
    {
        factory(Installment::class, 10)->create();

        $this->call('GET', '/api/v1/installment');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowInstallmentResponseIsOk()
    {
        $installments = factory(Installment::class, 10)->create();
        $installment = $installments->get(5);

        $this->call('GET', sprintf('/api/v1/installment/%s', $installment->id));

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testListInstallmentJsonStructure()
    {
        $installments = factory(Installment::class, 2)->create();
        $first = $installments->first();
        $second = $installments->get(1);

        $this->call('GET', '/api/v1/installment');

        $this->seeJsonEquals([
            'count' => 2,
            'total' => 2,
            'first' => url('/api/v1/installment?page=1'),
            'next' => null,
            'previous' => null,
            'last' => url('/api/v1/installment?page=1'),
            'data' => [
                [
                    'id' => $first->id,
                    'name' => $first->name,
                    'order' => $first->order,
                    'url' => $first->url,
                ],
                [
                    'id' => $second->id,
                    'name' => $second->name,
                    'order' => $second->order,
                    'url' => $second->url,
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testShowInstallmentJsonStructure()
    {
        $platforms = factory(Platform::class, 3)->create();

        $installments = factory(Installment::class, 10)->create();
        $installment = $installments->get(4);
        $installment->platforms()->attach($platforms->pluck('id')->toArray());

        $this->call('GET', sprintf('/api/v1/installment/%s', $installment->id));

        $this->seeJsonEquals([
            'id' => $installment->id,
            'name' => $installment->name,
            'order' => $installment->order,
            'url' => $installment->url,
            'platforms' => $installment->platforms->jsonSerialize(),
        ]);
    }
}
