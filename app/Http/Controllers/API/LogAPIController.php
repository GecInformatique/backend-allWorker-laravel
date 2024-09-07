<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLogAPIRequest;
use App\Http\Requests\API\UpdateLogAPIRequest;
use App\Models\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class LogController
 */

class LogAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/logs",
     *      summary="getLogList",
     *      tags={"Log"},
     *      description="Get all Logs",
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
     *                  @OA\Items(ref="#/components/schemas/Log")
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
        $query = Log::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $logs = $query->get();

        return $this->sendResponse(
            $logs->toArray(),
            __('messages.retrieved', ['model' => __('models/logs.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/logs",
     *      summary="createLog",
     *      tags={"Log"},
     *      description="Create Log",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Log")
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
     *                  ref="#/components/schemas/Log"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLogAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Log $log */
        $log = Log::create($input);

        return $this->sendResponse(
            $log->toArray(),
            __('messages.saved', ['model' => __('models/logs.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/logs/{id}",
     *      summary="getLogItem",
     *      tags={"Log"},
     *      description="Get Log",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Log",
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
     *                  ref="#/components/schemas/Log"
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
        /** @var Log $log */
        $log = Log::find($id);

        if (empty($log)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/logs.singular')])
            );
        }

        return $this->sendResponse(
            $log->toArray(),
            __('messages.retrieved', ['model' => __('models/logs.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/logs/{id}",
     *      summary="updateLog",
     *      tags={"Log"},
     *      description="Update Log",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Log",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Log")
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
     *                  ref="#/components/schemas/Log"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLogAPIRequest $request): JsonResponse
    {
        /** @var Log $log */
        $log = Log::find($id);

        if (empty($log)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/logs.singular')])
            );
        }

        $log->fill($request->all());
        $log->save();

        return $this->sendResponse(
            $log->toArray(),
            __('messages.updated', ['model' => __('models/logs.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/logs/{id}",
     *      summary="deleteLog",
     *      tags={"Log"},
     *      description="Delete Log",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Log",
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
        /** @var Log $log */
        $log = Log::find($id);

        if (empty($log)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/logs.singular')])
            );
        }

        $log->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/logs.singular')])
        );
    }
}
