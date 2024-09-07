<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Newsletter;

class NewsletterApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_newsletter()
    {
        $newsletter = Newsletter::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/newsletters', $newsletter
        );

        $this->assertApiResponse($newsletter);
    }

    /**
     * @test
     */
    public function test_read_newsletter()
    {
        $newsletter = Newsletter::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/newsletters/'.$newsletter->id
        );

        $this->assertApiResponse($newsletter->toArray());
    }

    /**
     * @test
     */
    public function test_update_newsletter()
    {
        $newsletter = Newsletter::factory()->create();
        $editedNewsletter = Newsletter::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/newsletters/'.$newsletter->id,
            $editedNewsletter
        );

        $this->assertApiResponse($editedNewsletter);
    }

    /**
     * @test
     */
    public function test_delete_newsletter()
    {
        $newsletter = Newsletter::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/newsletters/'.$newsletter->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/newsletters/'.$newsletter->id
        );

        $this->response->assertStatus(404);
    }
}
