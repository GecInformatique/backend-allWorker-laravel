<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInvoiceAPIRequest;
use App\Http\Requests\API\UpdateInvoiceAPIRequest;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class InvoiceController
 */

class InvoiceAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/invoices",
     *      summary="getInvoiceList",
     *      tags={"Invoice"},
     *      description="Get all Invoices",
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
     *                  @OA\Items(ref="#/components/schemas/Invoice")
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
        $query = Invoice::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $invoices = $query->get();

        return $this->sendResponse(
            $invoices->toArray(),
            __('messages.retrieved', ['model' => __('models/invoices.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/invoices",
     *      summary="createInvoice",
     *      tags={"Invoice"},
     *      description="Create Invoice",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Invoice")
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
     *                  ref="#/components/schemas/Invoice"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateInvoiceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Invoice $invoice */
        $invoice = Invoice::create($input);

        return $this->sendResponse(
            $invoice->toArray(),
            __('messages.saved', ['model' => __('models/invoices.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/invoices/{id}",
     *      summary="getInvoiceItem",
     *      tags={"Invoice"},
     *      description="Get Invoice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Invoice",
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
     *                  ref="#/components/schemas/Invoice"
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
        /** @var Invoice $invoice */
        $invoice = Invoice::find($id);

        if (empty($invoice)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/invoices.singular')])
            );
        }

        return $this->sendResponse(
            $invoice->toArray(),
            __('messages.retrieved', ['model' => __('models/invoices.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/invoices/{id}",
     *      summary="updateInvoice",
     *      tags={"Invoice"},
     *      description="Update Invoice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Invoice",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Invoice")
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
     *                  ref="#/components/schemas/Invoice"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateInvoiceAPIRequest $request): JsonResponse
    {
        /** @var Invoice $invoice */
        $invoice = Invoice::find($id);

        if (empty($invoice)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/invoices.singular')])
            );
        }

        $invoice->fill($request->all());
        $invoice->save();

        return $this->sendResponse(
            $invoice->toArray(),
            __('messages.updated', ['model' => __('models/invoices.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/invoices/{id}",
     *      summary="deleteInvoice",
     *      tags={"Invoice"},
     *      description="Delete Invoice",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Invoice",
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
        /** @var Invoice $invoice */
        $invoice = Invoice::find($id);

        if (empty($invoice)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/invoices.singular')])
            );
        }

        $invoice->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/invoices.singular')])
        );
    }
}
