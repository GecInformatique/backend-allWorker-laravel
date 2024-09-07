<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Specialism;

class SpecialismApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_specialism()
    {
        $specialism = Specialism::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/specialisms', $specialism
        );

        $this->assertApiResponse($specialism);
    }

    /**
     * @test
     */
    public function test_read_specialism()
    {
        $specialism = Specialism::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/specialisms/'.$specialism->id
        );

        $this->assertApiResponse($specialism->toArray());
    }

    /**
     * @test
     */
    public function test_update_specialism()
    {
        $specialism = Specialism::factory()->create();
        $editedSpecialism = Specialism::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/specialisms/'.$specialism->id,
            $editedSpecialism
        );

        $this->assertApiResponse($editedSpecialism);
    }

    /**
     * @test
     */
    public function test_delete_specialism()
    {
        $specialism = Specialism::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/specialisms/'.$specialism->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/specialisms/'.$specialism->id
        );

        $this->response->assertStatus(404);
    }
}
