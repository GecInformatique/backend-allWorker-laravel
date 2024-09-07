<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGroupAPIRequest;
use App\Http\Requests\API\UpdateGroupAPIRequest;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class GroupController
 */

class GroupAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/groups",
     *      summary="getGroupList",
     *      tags={"Group"},
     *      description="Get all Groups",
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
     *                  @OA\Items(ref="#/components/schemas/Group")
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
        $query = Group::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $groups = $query->get();

        return $this->sendResponse(
            $groups->toArray(),
            __('messages.retrieved', ['model' => __('models/groups.plural')])
        );
    }
    /**
     * @OA\Get(
     *      path="/website/groups",
     *      summary="getGroupListWebSite",
     *      tags={"Group"},
     *      description="Get all Groups website",
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
     *                  @OA\Items(ref="#/components/schemas/Group")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getGroupListWebSite(Request $request): JsonResponse
    {
        $query = Group::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $groups = $query->get();

        return $this->sendResponse(
            $groups->toArray(),
            __('messages.retrieved', ['model' => __('models/groups.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/groups",
     *      summary="createGroup",
     *      tags={"Group"},
     *      description="Create Group",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Group")
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
     *                  ref="#/components/schemas/Group"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGroupAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Group $group */
        $group = Group::create($input);

        return $this->sendResponse(
            $group->toArray(),
            __('messages.saved', ['model' => __('models/groups.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/groups/{id}",
     *      summary="getGroupItem",
     *      tags={"Group"},
     *      description="Get Group",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Group",
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
     *                  ref="#/components/schemas/Group"
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
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/groups.singular')])
            );
        }

        return $this->sendResponse(
            $group->toArray(),
            __('messages.retrieved', ['model' => __('models/groups.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/groups/{id}",
     *      summary="updateGroup",
     *      tags={"Group"},
     *      description="Update Group",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Group",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Group")
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
     *                  ref="#/components/schemas/Group"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGroupAPIRequest $request): JsonResponse
    {
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/groups.singular')])
            );
        }

        $group->fill($request->all());
        $group->save();

        return $this->sendResponse(
            $group->toArray(),
            __('messages.updated', ['model' => __('models/groups.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/groups/{id}",
     *      summary="deleteGroup",
     *      tags={"Group"},
     *      description="Delete Group",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Group",
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
        /** @var Group $group */
        $group = Group::find($id);

        if (empty($group)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/groups.singular')])
            );
        }

        $group->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/groups.singular')])
        );
    }
}
