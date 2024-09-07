<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Competence;

class CompetenceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_competence()
    {
        $competence = Competence::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/competences', $competence
        );

        $this->assertApiResponse($competence);
    }

    /**
     * @test
     */
    public function test_read_competence()
    {
        $competence = Competence::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/competences/'.$competence->id
        );

        $this->assertApiResponse($competence->toArray());
    }

    /**
     * @test
     */
    public function test_update_competence()
    {
        $competence = Competence::factory()->create();
        $editedCompetence = Competence::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/competences/'.$competence->id,
            $editedCompetence
        );

        $this->assertApiResponse($editedCompetence);
    }

    /**
     * @test
     */
    public function test_delete_competence()
    {
        $competence = Competence::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/competences/'.$competence->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/competences/'.$competence->id
        );

        $this->response->assertStatus(404);
    }
}
