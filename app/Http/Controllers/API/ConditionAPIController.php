<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateConditionAPIRequest;
use App\Http\Requests\API\UpdateConditionAPIRequest;
use App\Models\Condition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ConditionController
 */

class ConditionAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/conditions",
     *      summary="getConditionList",
     *      tags={"Condition"},
     *      description="Get all Conditions",
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
     *                  @OA\Items(ref="#/components/schemas/Condition")
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
        $query = Condition::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $conditions = $query->get();

        return $this->sendResponse(
            $conditions->toArray(),
            __('messages.retrieved', ['model' => __('models/conditions.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/conditions",
     *      summary="createCondition",
     *      tags={"Condition"},
     *      description="Create Condition",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Condition")
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
     *                  ref="#/components/schemas/Condition"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateConditionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Condition $condition */
        $condition = Condition::create($input);

        return $this->sendResponse(
            $condition->toArray(),
            __('messages.saved', ['model' => __('models/conditions.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/conditions/{id}",
     *      summary="getConditionItem",
     *      tags={"Condition"},
     *      description="Get Condition",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Condition",
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
     *                  ref="#/components/schemas/Condition"
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
        /** @var Condition $condition */
        $condition = Condition::find($id);

        if (empty($condition)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/conditions.singular')])
            );
        }

        return $this->sendResponse(
            $condition->toArray(),
            __('messages.retrieved', ['model' => __('models/conditions.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/conditions/{id}",
     *      summary="updateCondition",
     *      tags={"Condition"},
     *      description="Update Condition",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Condition",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Condition")
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
     *                  ref="#/components/schemas/Condition"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateConditionAPIRequest $request): JsonResponse
    {
        /** @var Condition $condition */
        $condition = Condition::find($id);

        if (empty($condition)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/conditions.singular')])
            );
        }

        $condition->fill($request->all());
        $condition->save();

        return $this->sendResponse(
            $condition->toArray(),
            __('messages.updated', ['model' => __('models/conditions.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/conditions/{id}",
     *      summary="deleteCondition",
     *      tags={"Condition"},
     *      description="Delete Condition",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Condition",
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
        /** @var Condition $condition */
        $condition = Condition::find($id);

        if (empty($condition)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/conditions.singular')])
            );
        }

        $condition->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/conditions.singular')])
        );
    }
}
