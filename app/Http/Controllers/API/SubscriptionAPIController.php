<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSubscriptionAPIRequest;
use App\Http\Requests\API\UpdateSubscriptionAPIRequest;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class SubscriptionController
 */

class SubscriptionAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/subscriptions",
     *      summary="getSubscriptionList",
     *      tags={"Subscription"},
     *      description="Get all Subscriptions",
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
     *                  @OA\Items(ref="#/components/schemas/Subscription")
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
        $query = Subscription::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $subscriptions = $query->get();

        return $this->sendResponse(
            $subscriptions->toArray(),
            __('messages.retrieved', ['model' => __('models/subscriptions.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/subscriptions",
     *      summary="createSubscription",
     *      tags={"Subscription"},
     *      description="Create Subscription",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Subscription")
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
     *                  ref="#/components/schemas/Subscription"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSubscriptionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Subscription $subscription */
        $subscription = Subscription::create($input);

        return $this->sendResponse(
            $subscription->toArray(),
            __('messages.saved', ['model' => __('models/subscriptions.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/subscriptions/{id}",
     *      summary="getSubscriptionItem",
     *      tags={"Subscription"},
     *      description="Get Subscription",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Subscription",
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
     *                  ref="#/components/schemas/Subscription"
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
        /** @var Subscription $subscription */
        $subscription = Subscription::find($id);

        if (empty($subscription)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/subscriptions.singular')])
            );
        }

        return $this->sendResponse(
            $subscription->toArray(),
            __('messages.retrieved', ['model' => __('models/subscriptions.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/subscriptions/{id}",
     *      summary="updateSubscription",
     *      tags={"Subscription"},
     *      description="Update Subscription",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Subscription",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Subscription")
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
     *                  ref="#/components/schemas/Subscription"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSubscriptionAPIRequest $request): JsonResponse
    {
        /** @var Subscription $subscription */
        $subscription = Subscription::find($id);

        if (empty($subscription)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/subscriptions.singular')])
            );
        }

        $subscription->fill($request->all());
        $subscription->save();

        return $this->sendResponse(
            $subscription->toArray(),
            __('messages.updated', ['model' => __('models/subscriptions.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/subscriptions/{id}",
     *      summary="deleteSubscription",
     *      tags={"Subscription"},
     *      description="Delete Subscription",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Subscription",
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
        /** @var Subscription $subscription */
        $subscription = Subscription::find($id);

        if (empty($subscription)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/subscriptions.singular')])
            );
        }

        $subscription->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/subscriptions.singular')])
        );
    }
}
