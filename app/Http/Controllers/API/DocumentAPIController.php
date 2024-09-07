<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDocumentAPIRequest;
use App\Http\Requests\API\UpdateDocumentAPIRequest;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DocumentController
 */

class DocumentAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/documents",
     *      summary="getDocumentList",
     *      tags={"Document"},
     *      description="Get all Documents",
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
     *                  @OA\Items(ref="#/components/schemas/Document")
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
        $query = Document::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $documents = $query->get();

        return $this->sendResponse(
            $documents->toArray(),
            __('messages.retrieved', ['model' => __('models/documents.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/documents",
     *      summary="createDocument",
     *      tags={"Document"},
     *      description="Create Document",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Document")
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
     *                  ref="#/components/schemas/Document"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDocumentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Document $document */
        $document = Document::create($input);

        return $this->sendResponse(
            $document->toArray(),
            __('messages.saved', ['model' => __('models/documents.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/documents/{id}",
     *      summary="getDocumentItem",
     *      tags={"Document"},
     *      description="Get Document",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Document",
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
     *                  ref="#/components/schemas/Document"
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
        /** @var Document $document */
        $document = Document::find($id);

        if (empty($document)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/documents.singular')])
            );
        }

        return $this->sendResponse(
            $document->toArray(),
            __('messages.retrieved', ['model' => __('models/documents.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/documents/{id}",
     *      summary="updateDocument",
     *      tags={"Document"},
     *      description="Update Document",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Document",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Document")
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
     *                  ref="#/components/schemas/Document"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDocumentAPIRequest $request): JsonResponse
    {
        /** @var Document $document */
        $document = Document::find($id);

        if (empty($document)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/documents.singular')])
            );
        }

        $document->fill($request->all());
        $document->save();

        return $this->sendResponse(
            $document->toArray(),
            __('messages.updated', ['model' => __('models/documents.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/documents/{id}",
     *      summary="deleteDocument",
     *      tags={"Document"},
     *      description="Delete Document",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Document",
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
        /** @var Document $document */
        $document = Document::find($id);

        if (empty($document)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/documents.singular')])
            );
        }

        $document->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/documents.singular')])
        );
    }
}
