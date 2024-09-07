<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Testimonial;

class TestimonialApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_testimonial()
    {
        $testimonial = Testimonial::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/testimonials', $testimonial
        );

        $this->assertApiResponse($testimonial);
    }

    /**
     * @test
     */
    public function test_read_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/testimonials/'.$testimonial->id
        );

        $this->assertApiResponse($testimonial->toArray());
    }

    /**
     * @test
     */
    public function test_update_testimonial()
    {
        $testimonial = Testimonial::factory()->create();
        $editedTestimonial = Testimonial::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/testimonials/'.$testimonial->id,
            $editedTestimonial
        );

        $this->assertApiResponse($editedTestimonial);
    }

    /**
     * @test
     */
    public function test_delete_testimonial()
    {
        $testimonial = Testimonial::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/testimonials/'.$testimonial->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/testimonials/'.$testimonial->id
        );

        $this->response->assertStatus(404);
    }
}
