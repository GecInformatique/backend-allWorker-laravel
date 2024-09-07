<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TaskController
 */

class TaskAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/tasks",
     *      summary="getTaskList",
     *      tags={"Task"},
     *      description="Get all Tasks",
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
     *                  @OA\Items(ref="#/components/schemas/Task")
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
        $query = Task::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $tasks = $query->get();

        return $this->sendResponse(
            $tasks->toArray(),
            __('messages.retrieved', ['model' => __('models/tasks.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/tasks",
     *      summary="createTask",
     *      tags={"Task"},
     *      description="Create Task",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Task")
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
     *                  ref="#/components/schemas/Task"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTaskAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Task $task */
        $task = Task::create($input);

        return $this->sendResponse(
            $task->toArray(),
            __('messages.saved', ['model' => __('models/tasks.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/tasks/{id}",
     *      summary="getTaskItem",
     *      tags={"Task"},
     *      description="Get Task",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Task",
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
     *                  ref="#/components/schemas/Task"
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
        /** @var Task $task */
        $task = Task::find($id);

        if (empty($task)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/tasks.singular')])
            );
        }

        return $this->sendResponse(
            $task->toArray(),
            __('messages.retrieved', ['model' => __('models/tasks.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/tasks/{id}",
     *      summary="updateTask",
     *      tags={"Task"},
     *      description="Update Task",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Task",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Task")
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
     *                  ref="#/components/schemas/Task"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTaskAPIRequest $request): JsonResponse
    {
        /** @var Task $task */
        $task = Task::find($id);

        if (empty($task)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/tasks.singular')])
            );
        }

        $task->fill($request->all());
        $task->save();

        return $this->sendResponse(
            $task->toArray(),
            __('messages.updated', ['model' => __('models/tasks.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/tasks/{id}",
     *      summary="deleteTask",
     *      tags={"Task"},
     *      description="Delete Task",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Task",
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
        /** @var Task $task */
        $task = Task::find($id);

        if (empty($task)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/tasks.singular')])
            );
        }

        $task->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/tasks.singular')])
        );
    }
}
