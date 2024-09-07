<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSpecialismAPIRequest;
use App\Http\Requests\API\UpdateSpecialismAPIRequest;
use App\Models\Specialism;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class SpecialismController
 */

class SpecialismAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/specialisms",
     *      summary="getSpecialismList",
     *      tags={"Specialism"},
     *      description="Get all Specialisms",
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
     *                  @OA\Items(ref="#/components/schemas/Specialism")
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
        $query = Specialism::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $specialisms = $query->get();

        return $this->sendResponse(
            $specialisms->toArray(),
            __('messages.retrieved', ['model' => __('models/specialisms.plural')])
        );
    }
    /**
     * @OA\Get(
     *      path="website/specialisms",
     *      summary="getSpecialismsWebSite",
     *      tags={"Specialism"},
     *      description="Get all Specialisms WebSite",
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
     *                  @OA\Items(ref="#/components/schemas/Specialism")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getSpecialismsWebSite(Request $request): JsonResponse
    {
        $query = Specialism::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $specialisms = $query->get();

        return $this->sendResponse(
            $specialisms->toArray(),
            __('messages.retrieved', ['model' => __('models/specialisms.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/specialisms",
     *      summary="createSpecialism",
     *      tags={"Specialism"},
     *      description="Create Specialism",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Specialism")
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
     *                  ref="#/components/schemas/Specialism"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSpecialismAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Specialism $specialism */
        $specialism = Specialism::create($input);

        return $this->sendResponse(
            $specialism->toArray(),
            __('messages.saved', ['model' => __('models/specialisms.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/specialisms/{id}",
     *      summary="getSpecialismItem",
     *      tags={"Specialism"},
     *      description="Get Specialism",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Specialism",
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
     *                  ref="#/components/schemas/Specialism"
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
        /** @var Specialism $specialism */
        $specialism = Specialism::find($id);

        if (empty($specialism)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/specialisms.singular')])
            );
        }

        return $this->sendResponse(
            $specialism->toArray(),
            __('messages.retrieved', ['model' => __('models/specialisms.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/specialisms/{idProfession}",
     *      summary="getSpecialismsByProfessionWebSite",
     *      tags={"Specialism"},
     *      description="Get Specialisms By Profession WebSite",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Specialism",
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
     *                  ref="#/components/schemas/Specialism"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getSpecialismsByProfessionWebSite($idProfession): JsonResponse
    {
        $specialisms = Specialism::where('professions_id',$idProfession)
            ->where('enable',1)
            ->get();

        return $this->sendResponse(
            $specialisms->toArray(),
            __('messages.retrieved', ['model' => __('models/specialisms.plural')])
        );
    }

    /**
     * @OA\Put(
     *      path="/specialisms/{id}",
     *      summary="updateSpecialism",
     *      tags={"Specialism"},
     *      description="Update Specialism",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Specialism",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Specialism")
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
     *                  ref="#/components/schemas/Specialism"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSpecialismAPIRequest $request): JsonResponse
    {
        /** @var Specialism $specialism */
        $specialism = Specialism::find($id);

        if (empty($specialism)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/specialisms.singular')])
            );
        }

        $specialism->fill($request->all());
        $specialism->save();

        return $this->sendResponse(
            $specialism->toArray(),
            __('messages.updated', ['model' => __('models/specialisms.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/specialisms/{id}",
     *      summary="deleteSpecialism",
     *      tags={"Specialism"},
     *      description="Delete Specialism",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Specialism",
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
        /** @var Specialism $specialism */
        $specialism = Specialism::find($id);

        if (empty($specialism)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/specialisms.singular')])
            );
        }

        $specialism->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/specialisms.singular')])
        );
    }
}
