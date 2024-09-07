<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Education;

class EducationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_education()
    {
        $education = Education::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/education', $education
        );

        $this->assertApiResponse($education);
    }

    /**
     * @test
     */
    public function test_read_education()
    {
        $education = Education::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/education/'.$education->id
        );

        $this->assertApiResponse($education->toArray());
    }

    /**
     * @test
     */
    public function test_update_education()
    {
        $education = Education::factory()->create();
        $editedEducation = Education::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/education/'.$education->id,
            $editedEducation
        );

        $this->assertApiResponse($editedEducation);
    }

    /**
     * @test
     */
    public function test_delete_education()
    {
        $education = Education::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/education/'.$education->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/education/'.$education->id
        );

        $this->response->assertStatus(404);
    }
}
