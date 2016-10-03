<?php

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\ResourceController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @return void
     */
    public function testListResourceResponseIsOk()
    {
        $items = factory(Item::class, 10)->create();

        $this->call('GET', '/api/v1/item');

        $this->assertResponseOk();
    }

    /**
     * @return void
     */
    public function testShowResourceResponseIsOk()
    {
        $items = factory(Item::class, 10)->create();
        $item = $items->get(5);

        $this->call('GET', sprintf('/api/v1/item/%s', $item->id));

        $this->assertResponseOk();
    }

    /**
     * Test that the 'list' resource action returns the correct resource.
     *
     * This isn't a strict JSON structure check. We just look for a few 
     * attributes to check they are in the response.
     * 
     * @return void
     */
    public function testListResourceReturnsTheCorrectResource()
    {
        $items = factory(Item::class, 10)->create();
        $item = $items->get(2);

        $this->call('GET', '/api/v1/item');

        $this->seeJson([
            'id' => $item->id,
            'name' => $item->name
        ]);
    }

    /**
     * Test that the 'show' resource action returns the correct resource.
     *
     * This isn't a strict JSON structure check. We just look for a few 
     * attributes to check they are in the response.
     * 
     * @return void
     */
    public function testShowResourceReturnsTheCorrectResource()
    {
        $items = factory(Item::class, 10)->create();
        $item = $items->get(6);

        $this->call('GET', sprintf('/api/v1/item/%s', $item->id));

        $this->seeJson([
            'id' => $item->id,
            'name' => $item->name,
        ]);
    }

    /**
     * @return void
     */
    public function testListInvalidResourceReturnsPageNotFound()
    {
        $this->call('GET', '/api/v1/cake');

        $this->assertResponseStatus(404);
    }

    /**
     * @return void
     */
    public function testShowInvalidResourceReturnsPageNotFound()
    {
        $this->call('GET', '/api/v1/cake/99');

        $this->assertResponseStatus(404);
    }

    /**
     * @return void
     */
    public function testResourceNotFoundReturnsPageNotFound()
    {
        $items = factory(Item::class, 5)->create();

        $this->call('GET', sprintf('/api/v1/item/%s', 'non-existant-id'));

        $this->assertResponseStatus(404);
    }

    /**
     * Ensure a request for a resource that doesn't implement 
     * ShowableResourceInterface throws a NotFoundHttpException.
     * 
     * @return void
     */
    public function testNonShowableResourceCannotBeShown()
    {
        $model = Mockery::mock(Model::class);

        $this->setExpectedException(NotFoundHttpException::class);

        $controller = new ResourceController();
        $controller->showResource($model, 1);
    }

    /**
     * Ensure a request for a resource that doesn't implement 
     * ListableResourceInterface throws a NotFoundHttpException.
     * 
     * @return void
     */
    public function testNonListableResourceCannotBeListed()
    {
        $model = Mockery::mock(Model::class);
        $request = Mockery::mock(Request::class);

        $this->setExpectedException(NotFoundHttpException::class);

        $controller = new ResourceController();
        $controller->listResource($model, $request);
    }

    /**
     * @return void
     */
    public function testResourceListPagination()
    {
        $items = factory(Item::class, 201)->create();
        $count = 20;
        $page = 2;

        $this->call('GET', sprintf('/api/v1/item?limit=%d&page=%d', $count, $page));

        $this->seeJson([
            'count' => 20,
            'total' => $items->count(),
            'first' => url('/api/v1/item?page=1'),
            'next' => url('/api/v1/item?page=3'),
            'previous' => url('/api/v1/item?page=1'),
            'last' => url('/api/v1/item?page=11'),
        ]);
    }
}
