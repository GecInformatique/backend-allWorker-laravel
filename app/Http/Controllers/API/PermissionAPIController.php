<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePermissionAPIRequest;
use App\Http\Requests\API\UpdatePermissionAPIRequest;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PermissionController
 */

class PermissionAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/permissions",
     *      summary="getPermissionList",
     *      tags={"Permission"},
     *      description="Get all Permissions",
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
     *                  @OA\Items(ref="#/components/schemas/Permission")
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
        $query = Permission::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $permissions = $query->get();

        return $this->sendResponse(
            $permissions->toArray(),
            __('messages.retrieved', ['model' => __('models/permissions.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/permissions",
     *      summary="createPermission",
     *      tags={"Permission"},
     *      description="Create Permission",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Permission")
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
     *                  ref="#/components/schemas/Permission"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePermissionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Permission $permission */
        $permission = Permission::create($input);

        return $this->sendResponse(
            $permission->toArray(),
            __('messages.saved', ['model' => __('models/permissions.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/permissions/{id}",
     *      summary="getPermissionItem",
     *      tags={"Permission"},
     *      description="Get Permission",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Permission",
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
     *                  ref="#/components/schemas/Permission"
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
        /** @var Permission $permission */
        $permission = Permission::find($id);

        if (empty($permission)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/permissions.singular')])
            );
        }

        return $this->sendResponse(
            $permission->toArray(),
            __('messages.retrieved', ['model' => __('models/permissions.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/permissions/{id}",
     *      summary="updatePermission",
     *      tags={"Permission"},
     *      description="Update Permission",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Permission",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Permission")
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
     *                  ref="#/components/schemas/Permission"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePermissionAPIRequest $request): JsonResponse
    {
        /** @var Permission $permission */
        $permission = Permission::find($id);

        if (empty($permission)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/permissions.singular')])
            );
        }

        $permission->fill($request->all());
        $permission->save();

        return $this->sendResponse(
            $permission->toArray(),
            __('messages.updated', ['model' => __('models/permissions.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/permissions/{id}",
     *      summary="deletePermission",
     *      tags={"Permission"},
     *      description="Delete Permission",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Permission",
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
        /** @var Permission $permission */
        $permission = Permission::find($id);

        if (empty($permission)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/permissions.singular')])
            );
        }

        $permission->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/permissions.singular')])
        );
    }
}
