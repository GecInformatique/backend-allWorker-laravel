<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdvertisementAPIRequest;
use App\Http\Requests\API\UpdateAdvertisementAPIRequest;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class AdvertisementController
 */

class AdvertisementAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/advertisements",
     *      summary="getAdvertisementList",
     *      tags={"Advertisement"},
     *      description="Get all Advertisements",
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
     *                  @OA\Items(ref="#/components/schemas/Advertisement")
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
        $query = Advertisement::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $advertisements = $query->get();

        return $this->sendResponse(
            AdvertisementResource::collection($advertisements),
            __('messages.retrieved', ['model' => __('models/advertisements.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/advertisements",
     *      summary="createAdvertisement",
     *      tags={"Advertisement"},
     *      description="Create Advertisement",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Advertisement")
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
     *                  ref="#/components/schemas/Advertisement"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdvertisementAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Advertisement $advertisement */
        $advertisement = Advertisement::create($input);

        return $this->sendResponse(
            $advertisement->toArray(),
            __('messages.saved', ['model' => __('models/advertisements.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/advertisements/{id}",
     *      summary="getAdvertisementItem",
     *      tags={"Advertisement"},
     *      description="Get Advertisement",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Advertisement",
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
     *                  ref="#/components/schemas/Advertisement"
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
        /** @var Advertisement $advertisement */
        $advertisement = Advertisement::find($id);

        if (empty($advertisement)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/advertisements.singular')])
            );
        }

        return $this->sendResponse(
            $advertisement->toArray(),
            __('messages.retrieved', ['model' => __('models/advertisements.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/advertisements/{id}",
     *      summary="updateAdvertisement",
     *      tags={"Advertisement"},
     *      description="Update Advertisement",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Advertisement",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Advertisement")
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
     *                  ref="#/components/schemas/Advertisement"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdvertisementAPIRequest $request): JsonResponse
    {
        /** @var Advertisement $advertisement */
        $advertisement = Advertisement::find($id);

        if (empty($advertisement)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/advertisements.singular')])
            );
        }

        $advertisement->fill($request->all());
        $advertisement->save();

        return $this->sendResponse(
            $advertisement->toArray(),
            __('messages.updated', ['model' => __('models/advertisements.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/advertisements/{id}",
     *      summary="deleteAdvertisement",
     *      tags={"Advertisement"},
     *      description="Delete Advertisement",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Advertisement",
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
        /** @var Advertisement $advertisement */
        $advertisement = Advertisement::find($id);

        if (empty($advertisement)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/advertisements.singular')])
            );
        }

        $advertisement->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/advertisements.singular')])
        );
    }
}
