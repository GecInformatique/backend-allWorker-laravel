<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CandidateHasCompetence;

class CandidateHasCompetenceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_candidate_has_competence()
    {
        $candidateHasCompetence = CandidateHasCompetence::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/candidate_has_competences', $candidateHasCompetence
        );

        $this->assertApiResponse($candidateHasCompetence);
    }

    /**
     * @test
     */
    public function test_read_candidate_has_competence()
    {
        $candidateHasCompetence = CandidateHasCompetence::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/candidate_has_competences/'.$candidateHasCompetence->id
        );

        $this->assertApiResponse($candidateHasCompetence->toArray());
    }

    /**
     * @test
     */
    public function test_update_candidate_has_competence()
    {
        $candidateHasCompetence = CandidateHasCompetence::factory()->create();
        $editedCandidateHasCompetence = CandidateHasCompetence::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/candidate_has_competences/'.$candidateHasCompetence->id,
            $editedCandidateHasCompetence
        );

        $this->assertApiResponse($editedCandidateHasCompetence);
    }

    /**
     * @test
     */
    public function test_delete_candidate_has_competence()
    {
        $candidateHasCompetence = CandidateHasCompetence::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/candidate_has_competences/'.$candidateHasCompetence->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/candidate_has_competences/'.$candidateHasCompetence->id
        );

        $this->response->assertStatus(404);
    }
}
