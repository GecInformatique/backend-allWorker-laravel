<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTypeDocumentAPIRequest;
use App\Http\Requests\API\UpdateTypeDocumentAPIRequest;
use App\Models\TypeDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TypeDocumentController
 */

class TypeDocumentAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/type-documents",
     *      summary="getTypeDocumentList",
     *      tags={"TypeDocument"},
     *      description="Get all TypeDocuments",
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
     *                  @OA\Items(ref="#/components/schemas/TypeDocument")
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
        $query = TypeDocument::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $typeDocuments = $query->get();

        return $this->sendResponse(
            $typeDocuments->toArray(),
            __('messages.retrieved', ['model' => __('models/typeDocuments.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/type-documents",
     *      summary="createTypeDocument",
     *      tags={"TypeDocument"},
     *      description="Create TypeDocument",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/TypeDocument")
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
     *                  ref="#/components/schemas/TypeDocument"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTypeDocumentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TypeDocument $typeDocument */
        $typeDocument = TypeDocument::create($input);

        return $this->sendResponse(
            $typeDocument->toArray(),
            __('messages.saved', ['model' => __('models/typeDocuments.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/type-documents/{id}",
     *      summary="getTypeDocumentItem",
     *      tags={"TypeDocument"},
     *      description="Get TypeDocument",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TypeDocument",
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
     *                  ref="#/components/schemas/TypeDocument"
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
        /** @var TypeDocument $typeDocument */
        $typeDocument = TypeDocument::find($id);

        if (empty($typeDocument)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/typeDocuments.singular')])
            );
        }

        return $this->sendResponse(
            $typeDocument->toArray(),
            __('messages.retrieved', ['model' => __('models/typeDocuments.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/type-documents/{id}",
     *      summary="updateTypeDocument",
     *      tags={"TypeDocument"},
     *      description="Update TypeDocument",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TypeDocument",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/TypeDocument")
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
     *                  ref="#/components/schemas/TypeDocument"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTypeDocumentAPIRequest $request): JsonResponse
    {
        /** @var TypeDocument $typeDocument */
        $typeDocument = TypeDocument::find($id);

        if (empty($typeDocument)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/typeDocuments.singular')])
            );
        }

        $typeDocument->fill($request->all());
        $typeDocument->save();

        return $this->sendResponse(
            $typeDocument->toArray(),
            __('messages.updated', ['model' => __('models/typeDocuments.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/type-documents/{id}",
     *      summary="deleteTypeDocument",
     *      tags={"TypeDocument"},
     *      description="Delete TypeDocument",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of TypeDocument",
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
        /** @var TypeDocument $typeDocument */
        $typeDocument = TypeDocument::find($id);

        if (empty($typeDocument)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/typeDocuments.singular')])
            );
        }

        $typeDocument->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/typeDocuments.singular')])
        );
    }
}
