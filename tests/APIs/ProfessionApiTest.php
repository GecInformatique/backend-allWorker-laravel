<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Profession;

class ProfessionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_profession()
    {
        $profession = Profession::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/professions', $profession
        );

        $this->assertApiResponse($profession);
    }

    /**
     * @test
     */
    public function test_read_profession()
    {
        $profession = Profession::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/professions/'.$profession->id
        );

        $this->assertApiResponse($profession->toArray());
    }

    /**
     * @test
     */
    public function test_update_profession()
    {
        $profession = Profession::factory()->create();
        $editedProfession = Profession::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/professions/'.$profession->id,
            $editedProfession
        );

        $this->assertApiResponse($editedProfession);
    }

    /**
     * @test
     */
    public function test_delete_profession()
    {
        $profession = Profession::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/professions/'.$profession->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/professions/'.$profession->id
        );

        $this->response->assertStatus(404);
    }
}
