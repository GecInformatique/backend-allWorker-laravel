<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRoleAPIRequest;
use App\Http\Requests\API\UpdateRoleAPIRequest;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class RoleController
 */

class RoleAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/roles",
     *      summary="getRoleList",
     *      tags={"Role"},
     *      description="Get all Roles",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Role")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Role::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $roles = $query->get();

        return $this->sendResponse(
            $roles->toArray(),
            __('messages.retrieved', ['model' => __('models/roles.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/roles",
     *      summary="createRole",
     *      tags={"Role"},
     *      description="Create Role",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Role")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Role"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRoleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Role $role */
        $role = Role::create($input);

        return $this->sendResponse(
            $role->toArray(),
            __('messages.saved', ['model' => __('models/roles.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/roles/{id}",
     *      summary="getRoleItem",
     *      tags={"Role"},
     *      description="Get Role",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Role",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Role"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Role $role */
        $role = Role::find($id);

        if (empty($role)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/roles.singular')])
            );
        }

        return $this->sendResponse(
            $role->toArray(),
            __('messages.retrieved', ['model' => __('models/roles.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/roles/{id}",
     *      summary="updateRole",
     *      tags={"Role"},
     *      description="Update Role",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Role",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Role")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Role"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRoleAPIRequest $request): JsonResponse
    {
        /** @var Role $role */
        $role = Role::find($id);

        if (empty($role)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/roles.singular')])
            );
        }

        $role->fill($request->all());
        $role->save();

        return $this->sendResponse(
            $role->toArray(),
            __('messages.updated', ['model' => __('models/roles.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/roles/{id}",
     *      summary="deleteRole",
     *      tags={"Role"},
     *      description="Delete Role",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Role",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Role $role */
        $role = Role::find($id);

        if (empty($role)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/roles.singular')])
            );
        }

        $role->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/roles.singular')])
        );
    }
}
