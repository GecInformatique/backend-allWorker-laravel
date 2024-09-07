<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateOauthProviderAPIRequest;
use App\Http\Requests\API\UpdateOauthProviderAPIRequest;
use App\Models\OauthProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class OauthProviderController
 */

class OauthProviderAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/oauth-providers",
     *      summary="getOauthProviderList",
     *      tags={"OauthProvider"},
     *      description="Get all OauthProviders",
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
     *                  @OA\Items(ref="#/components/schemas/OauthProvider")
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
        $query = OauthProvider::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $oauthProviders = $query->get();

        return $this->sendResponse(
            $oauthProviders->toArray(),
            __('messages.retrieved', ['model' => __('models/oauthProviders.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/oauth-providers",
     *      summary="createOauthProvider",
     *      tags={"OauthProvider"},
     *      description="Create OauthProvider",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/OauthProvider")
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
     *                  ref="#/components/schemas/OauthProvider"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateOauthProviderAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var OauthProvider $oauthProvider */
        $oauthProvider = OauthProvider::create($input);

        return $this->sendResponse(
            $oauthProvider->toArray(),
            __('messages.saved', ['model' => __('models/oauthProviders.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/oauth-providers/{id}",
     *      summary="getOauthProviderItem",
     *      tags={"OauthProvider"},
     *      description="Get OauthProvider",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of OauthProvider",
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
     *                  ref="#/components/schemas/OauthProvider"
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
        /** @var OauthProvider $oauthProvider */
        $oauthProvider = OauthProvider::find($id);

        if (empty($oauthProvider)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/oauthProviders.singular')])
            );
        }

        return $this->sendResponse(
            $oauthProvider->toArray(),
            __('messages.retrieved', ['model' => __('models/oauthProviders.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/oauth-providers/{id}",
     *      summary="updateOauthProvider",
     *      tags={"OauthProvider"},
     *      description="Update OauthProvider",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of OauthProvider",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/OauthProvider")
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
     *                  ref="#/components/schemas/OauthProvider"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateOauthProviderAPIRequest $request): JsonResponse
    {
        /** @var OauthProvider $oauthProvider */
        $oauthProvider = OauthProvider::find($id);

        if (empty($oauthProvider)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/oauthProviders.singular')])
            );
        }

        $oauthProvider->fill($request->all());
        $oauthProvider->save();

        return $this->sendResponse(
            $oauthProvider->toArray(),
            __('messages.updated', ['model' => __('models/oauthProviders.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/oauth-providers/{id}",
     *      summary="deleteOauthProvider",
     *      tags={"OauthProvider"},
     *      description="Delete OauthProvider",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of OauthProvider",
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
        /** @var OauthProvider $oauthProvider */
        $oauthProvider = OauthProvider::find($id);

        if (empty($oauthProvider)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/oauthProviders.singular')])
            );
        }

        $oauthProvider->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/oauthProviders.singular')])
        );
    }
}
