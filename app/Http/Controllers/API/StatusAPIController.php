<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStatusAPIRequest;
use App\Http\Requests\API\UpdateStatusAPIRequest;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class StatusController
 */

class StatusAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/statuses",
     *      summary="getStatusList",
     *      tags={"Status"},
     *      description="Get all Statuses",
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
     *                  @OA\Items(ref="#/components/schemas/Status")
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
        $query = Status::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $statuses = $query->get();

        return $this->sendResponse(
            $statuses->toArray(),
            __('messages.retrieved', ['model' => __('models/statuses.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/statuses",
     *      summary="createStatus",
     *      tags={"Status"},
     *      description="Create Status",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Status")
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
     *                  ref="#/components/schemas/Status"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateStatusAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Status $status */
        $status = Status::create($input);

        return $this->sendResponse(
            $status->toArray(),
            __('messages.saved', ['model' => __('models/statuses.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/statuses/{id}",
     *      summary="getStatusItem",
     *      tags={"Status"},
     *      description="Get Status",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Status",
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
     *                  ref="#/components/schemas/Status"
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
        /** @var Status $status */
        $status = Status::find($id);

        if (empty($status)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/statuses.singular')])
            );
        }

        return $this->sendResponse(
            $status->toArray(),
            __('messages.retrieved', ['model' => __('models/statuses.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/statuses/{id}",
     *      summary="updateStatus",
     *      tags={"Status"},
     *      description="Update Status",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Status",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Status")
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
     *                  ref="#/components/schemas/Status"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateStatusAPIRequest $request): JsonResponse
    {
        /** @var Status $status */
        $status = Status::find($id);

        if (empty($status)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/statuses.singular')])
            );
        }

        $status->fill($request->all());
        $status->save();

        return $this->sendResponse(
            $status->toArray(),
            __('messages.updated', ['model' => __('models/statuses.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/statuses/{id}",
     *      summary="deleteStatus",
     *      tags={"Status"},
     *      description="Delete Status",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Status",
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
        /** @var Status $status */
        $status = Status::find($id);

        if (empty($status)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/statuses.singular')])
            );
        }

        $status->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/statuses.singular')])
        );
    }
}
