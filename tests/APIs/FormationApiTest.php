<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Formation;

class FormationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_formation()
    {
        $formation = Formation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/formations', $formation
        );

        $this->assertApiResponse($formation);
    }

    /**
     * @test
     */
    public function test_read_formation()
    {
        $formation = Formation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/formations/'.$formation->id
        );

        $this->assertApiResponse($formation->toArray());
    }

    /**
     * @test
     */
    public function test_update_formation()
    {
        $formation = Formation::factory()->create();
        $editedFormation = Formation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/formations/'.$formation->id,
            $editedFormation
        );

        $this->assertApiResponse($editedFormation);
    }

    /**
     * @test
     */
    public function test_delete_formation()
    {
        $formation = Formation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/formations/'.$formation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/formations/'.$formation->id
        );

        $this->response->assertStatus(404);
    }
}
