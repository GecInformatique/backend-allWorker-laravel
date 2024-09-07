<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNewsletterAPIRequest;
use App\Http\Requests\API\UpdateNewsletterAPIRequest;
use App\Models\Newsletter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class NewsletterController
 */

class NewsletterAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/newsletters",
     *      summary="getNewsletterList",
     *      tags={"Newsletter"},
     *      description="Get all Newsletters",
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
     *                  @OA\Items(ref="#/components/schemas/Newsletter")
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
        $query = Newsletter::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $newsletters = $query->get();

        return $this->sendResponse(
            $newsletters->toArray(),
            __('messages.retrieved', ['model' => __('models/newsletters.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/newsletters",
     *      summary="createNewsletter",
     *      tags={"Newsletter"},
     *      description="Create Newsletter",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Newsletter")
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
     *                  ref="#/components/schemas/Newsletter"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNewsletterAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Newsletter $newsletter */
        $newsletter = Newsletter::create($input);

        return $this->sendResponse(
            $newsletter->toArray(),
            __('messages.saved', ['model' => __('models/newsletters.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/newsletters/{id}",
     *      summary="getNewsletterItem",
     *      tags={"Newsletter"},
     *      description="Get Newsletter",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Newsletter",
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
     *                  ref="#/components/schemas/Newsletter"
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
        /** @var Newsletter $newsletter */
        $newsletter = Newsletter::find($id);

        if (empty($newsletter)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/newsletters.singular')])
            );
        }

        return $this->sendResponse(
            $newsletter->toArray(),
            __('messages.retrieved', ['model' => __('models/newsletters.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/newsletters/{id}",
     *      summary="updateNewsletter",
     *      tags={"Newsletter"},
     *      description="Update Newsletter",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Newsletter",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Newsletter")
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
     *                  ref="#/components/schemas/Newsletter"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNewsletterAPIRequest $request): JsonResponse
    {
        /** @var Newsletter $newsletter */
        $newsletter = Newsletter::find($id);

        if (empty($newsletter)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/newsletters.singular')])
            );
        }

        $newsletter->fill($request->all());
        $newsletter->save();

        return $this->sendResponse(
            $newsletter->toArray(),
            __('messages.updated', ['model' => __('models/newsletters.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/newsletters/{id}",
     *      summary="deleteNewsletter",
     *      tags={"Newsletter"},
     *      description="Delete Newsletter",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Newsletter",
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
        /** @var Newsletter $newsletter */
        $newsletter = Newsletter::find($id);

        if (empty($newsletter)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/newsletters.singular')])
            );
        }

        $newsletter->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/newsletters.singular')])
        );
    }
}
