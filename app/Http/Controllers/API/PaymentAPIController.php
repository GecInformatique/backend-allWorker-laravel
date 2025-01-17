<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePaymentAPIRequest;
use App\Http\Requests\API\UpdatePaymentAPIRequest;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PaymentController
 */

class PaymentAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/payments",
     *      summary="getPaymentList",
     *      tags={"Payment"},
     *      description="Get all Payments",
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
     *                  @OA\Items(ref="#/components/schemas/Payment")
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
        $query = Payment::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $payments = $query->get();

        return $this->sendResponse(
            $payments->toArray(),
            __('messages.retrieved', ['model' => __('models/payments.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/payments",
     *      summary="createPayment",
     *      tags={"Payment"},
     *      description="Create Payment",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Payment")
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
     *                  ref="#/components/schemas/Payment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePaymentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Payment $payment */
        $payment = Payment::create($input);

        return $this->sendResponse(
            $payment->toArray(),
            __('messages.saved', ['model' => __('models/payments.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/payments/{id}",
     *      summary="getPaymentItem",
     *      tags={"Payment"},
     *      description="Get Payment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Payment",
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
     *                  ref="#/components/schemas/Payment"
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
        /** @var Payment $payment */
        $payment = Payment::find($id);

        if (empty($payment)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/payments.singular')])
            );
        }

        return $this->sendResponse(
            $payment->toArray(),
            __('messages.retrieved', ['model' => __('models/payments.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/payments/{id}",
     *      summary="updatePayment",
     *      tags={"Payment"},
     *      description="Update Payment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Payment",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Payment")
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
     *                  ref="#/components/schemas/Payment"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePaymentAPIRequest $request): JsonResponse
    {
        /** @var Payment $payment */
        $payment = Payment::find($id);

        if (empty($payment)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/payments.singular')])
            );
        }

        $payment->fill($request->all());
        $payment->save();

        return $this->sendResponse(
            $payment->toArray(),
            __('messages.updated', ['model' => __('models/payments.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/payments/{id}",
     *      summary="deletePayment",
     *      tags={"Payment"},
     *      description="Delete Payment",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Payment",
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
        /** @var Payment $payment */
        $payment = Payment::find($id);

        if (empty($payment)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/payments.singular')])
            );
        }

        $payment->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/payments.singular')])
        );
    }
}
