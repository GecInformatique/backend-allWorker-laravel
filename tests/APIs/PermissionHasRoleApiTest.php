<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PermissionHasRole;

class PermissionHasRoleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_permission_has_role()
    {
        $permissionHasRole = PermissionHasRole::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/permission_has_roles', $permissionHasRole
        );

        $this->assertApiResponse($permissionHasRole);
    }

    /**
     * @test
     */
    public function test_read_permission_has_role()
    {
        $permissionHasRole = PermissionHasRole::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/permission_has_roles/'.$permissionHasRole->id
        );

        $this->assertApiResponse($permissionHasRole->toArray());
    }

    /**
     * @test
     */
    public function test_update_permission_has_role()
    {
        $permissionHasRole = PermissionHasRole::factory()->create();
        $editedPermissionHasRole = PermissionHasRole::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/permission_has_roles/'.$permissionHasRole->id,
            $editedPermissionHasRole
        );

        $this->assertApiResponse($editedPermissionHasRole);
    }

    /**
     * @test
     */
    public function test_delete_permission_has_role()
    {
        $permissionHasRole = PermissionHasRole::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/permission_has_roles/'.$permissionHasRole->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/permission_has_roles/'.$permissionHasRole->id
        );

        $this->response->assertStatus(404);
    }
}
