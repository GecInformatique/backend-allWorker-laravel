<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Favorite;

class FavoriteApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_favorite()
    {
        $favorite = Favorite::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/favorites', $favorite
        );

        $this->assertApiResponse($favorite);
    }

    /**
     * @test
     */
    public function test_read_favorite()
    {
        $favorite = Favorite::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/favorites/'.$favorite->id
        );

        $this->assertApiResponse($favorite->toArray());
    }

    /**
     * @test
     */
    public function test_update_favorite()
    {
        $favorite = Favorite::factory()->create();
        $editedFavorite = Favorite::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/favorites/'.$favorite->id,
            $editedFavorite
        );

        $this->assertApiResponse($editedFavorite);
    }

    /**
     * @test
     */
    public function test_delete_favorite()
    {
        $favorite = Favorite::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/favorites/'.$favorite->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/favorites/'.$favorite->id
        );

        $this->response->assertStatus(404);
    }
}
