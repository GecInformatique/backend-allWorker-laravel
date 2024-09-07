<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFavoriteAPIRequest;
use App\Http\Requests\API\UpdateFavoriteAPIRequest;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class FavoriteController
 */

class FavoriteAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/favorites",
     *      summary="getFavoriteList",
     *      tags={"Favorite"},
     *      description="Get all Favorites",
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
     *                  @OA\Items(ref="#/components/schemas/Favorite")
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
        $query = Favorite::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $favorites = $query->get();

        return $this->sendResponse(
            $favorites->toArray(),
            __('messages.retrieved', ['model' => __('models/favorites.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/favorites",
     *      summary="createFavorite",
     *      tags={"Favorite"},
     *      description="Create Favorite",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Favorite")
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
     *                  ref="#/components/schemas/Favorite"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFavoriteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Favorite $favorite */
        $favorite = Favorite::create($input);

        return $this->sendResponse(
            $favorite->toArray(),
            __('messages.saved', ['model' => __('models/favorites.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/favorites/{id}",
     *      summary="getFavoriteItem",
     *      tags={"Favorite"},
     *      description="Get Favorite",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Favorite",
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
     *                  ref="#/components/schemas/Favorite"
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
        /** @var Favorite $favorite */
        $favorite = Favorite::find($id);

        if (empty($favorite)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/favorites.singular')])
            );
        }

        return $this->sendResponse(
            $favorite->toArray(),
            __('messages.retrieved', ['model' => __('models/favorites.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/favorites/{id}",
     *      summary="updateFavorite",
     *      tags={"Favorite"},
     *      description="Update Favorite",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Favorite",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Favorite")
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
     *                  ref="#/components/schemas/Favorite"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFavoriteAPIRequest $request): JsonResponse
    {
        /** @var Favorite $favorite */
        $favorite = Favorite::find($id);

        if (empty($favorite)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/favorites.singular')])
            );
        }

        $favorite->fill($request->all());
        $favorite->save();

        return $this->sendResponse(
            $favorite->toArray(),
            __('messages.updated', ['model' => __('models/favorites.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/favorites/{id}",
     *      summary="deleteFavorite",
     *      tags={"Favorite"},
     *      description="Delete Favorite",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Favorite",
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
        /** @var Favorite $favorite */
        $favorite = Favorite::find($id);

        if (empty($favorite)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/favorites.singular')])
            );
        }

        $favorite->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/favorites.singular')])
        );
    }
}
