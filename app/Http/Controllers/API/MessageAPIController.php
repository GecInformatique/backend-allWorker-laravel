<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMessageAPIRequest;
use App\Http\Requests\API\UpdateMessageAPIRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class MessageController
 */

class MessageAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/messages",
     *      summary="getMessageList",
     *      tags={"Message"},
     *      description="Get all Messages",
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
     *                  @OA\Items(ref="#/components/schemas/Message")
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
        $query = Message::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $messages = $query->get();

        return $this->sendResponse(
            $messages->toArray(),
            __('messages.retrieved', ['model' => __('models/messages.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/messages",
     *      summary="createMessage",
     *      tags={"Message"},
     *      description="Create Message",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Message")
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
     *                  ref="#/components/schemas/Message"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMessageAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Message $message */
        $message = Message::create($input);

        return $this->sendResponse(
            $message->toArray(),
            __('messages.saved', ['model' => __('models/messages.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/messages/{id}",
     *      summary="getMessageItem",
     *      tags={"Message"},
     *      description="Get Message",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Message",
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
     *                  ref="#/components/schemas/Message"
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
        /** @var Message $message */
        $message = Message::find($id);

        if (empty($message)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/messages.singular')])
            );
        }

        return $this->sendResponse(
            $message->toArray(),
            __('messages.retrieved', ['model' => __('models/messages.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/messages/{id}",
     *      summary="updateMessage",
     *      tags={"Message"},
     *      description="Update Message",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Message",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Message")
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
     *                  ref="#/components/schemas/Message"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMessageAPIRequest $request): JsonResponse
    {
        /** @var Message $message */
        $message = Message::find($id);

        if (empty($message)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/messages.singular')])
            );
        }

        $message->fill($request->all());
        $message->save();

        return $this->sendResponse(
            $message->toArray(),
            __('messages.updated', ['model' => __('models/messages.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/messages/{id}",
     *      summary="deleteMessage",
     *      tags={"Message"},
     *      description="Delete Message",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Message",
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
        /** @var Message $message */
        $message = Message::find($id);

        if (empty($message)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/messages.singular')])
            );
        }

        $message->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/messages.singular')])
        );
    }
}
