<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\OauthProvider;

class OauthProviderApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_oauth_provider()
    {
        $oauthProvider = OauthProvider::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/oauth_providers', $oauthProvider
        );

        $this->assertApiResponse($oauthProvider);
    }

    /**
     * @test
     */
    public function test_read_oauth_provider()
    {
        $oauthProvider = OauthProvider::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/oauth_providers/'.$oauthProvider->id
        );

        $this->assertApiResponse($oauthProvider->toArray());
    }

    /**
     * @test
     */
    public function test_update_oauth_provider()
    {
        $oauthProvider = OauthProvider::factory()->create();
        $editedOauthProvider = OauthProvider::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/oauth_providers/'.$oauthProvider->id,
            $editedOauthProvider
        );

        $this->assertApiResponse($editedOauthProvider);
    }

    /**
     * @test
     */
    public function test_delete_oauth_provider()
    {
        $oauthProvider = OauthProvider::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/oauth_providers/'.$oauthProvider->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/oauth_providers/'.$oauthProvider->id
        );

        $this->response->assertStatus(404);
    }
}
