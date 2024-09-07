<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TypeDocument;

class TypeDocumentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_type_document()
    {
        $typeDocument = TypeDocument::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/type_documents', $typeDocument
        );

        $this->assertApiResponse($typeDocument);
    }

    /**
     * @test
     */
    public function test_read_type_document()
    {
        $typeDocument = TypeDocument::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/type_documents/'.$typeDocument->id
        );

        $this->assertApiResponse($typeDocument->toArray());
    }

    /**
     * @test
     */
    public function test_update_type_document()
    {
        $typeDocument = TypeDocument::factory()->create();
        $editedTypeDocument = TypeDocument::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/type_documents/'.$typeDocument->id,
            $editedTypeDocument
        );

        $this->assertApiResponse($editedTypeDocument);
    }

    /**
     * @test
     */
    public function test_delete_type_document()
    {
        $typeDocument = TypeDocument::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/type_documents/'.$typeDocument->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/type_documents/'.$typeDocument->id
        );

        $this->response->assertStatus(404);
    }
}
