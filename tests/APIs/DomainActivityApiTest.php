<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\DomainActivity;

class DomainActivityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_domain_activity()
    {
        $domainActivity = DomainActivity::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/domain_activities', $domainActivity
        );

        $this->assertApiResponse($domainActivity);
    }

    /**
     * @test
     */
    public function test_read_domain_activity()
    {
        $domainActivity = DomainActivity::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/domain_activities/'.$domainActivity->id
        );

        $this->assertApiResponse($domainActivity->toArray());
    }

    /**
     * @test
     */
    public function test_update_domain_activity()
    {
        $domainActivity = DomainActivity::factory()->create();
        $editedDomainActivity = DomainActivity::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/domain_activities/'.$domainActivity->id,
            $editedDomainActivity
        );

        $this->assertApiResponse($editedDomainActivity);
    }

    /**
     * @test
     */
    public function test_delete_domain_activity()
    {
        $domainActivity = DomainActivity::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/domain_activities/'.$domainActivity->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/domain_activities/'.$domainActivity->id
        );

        $this->response->assertStatus(404);
    }
}
