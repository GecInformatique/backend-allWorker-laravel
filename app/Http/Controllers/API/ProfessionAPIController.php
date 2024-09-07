<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProfessionAPIRequest;
use App\Http\Requests\API\UpdateProfessionAPIRequest;
use App\Models\Profession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProfessionController
 */

class ProfessionAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/professions",
     *      summary="getProfessionList",
     *      tags={"Profession"},
     *      description="Get all Professions",
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
     *                  @OA\Items(ref="#/components/schemas/Profession")
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
        $query = Profession::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $professions = $query->get();

        return $this->sendResponse(
            $professions->toArray(),
            __('messages.retrieved', ['model' => __('models/professions.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/professions",
     *      summary="createProfession",
     *      tags={"Profession"},
     *      description="Create Profession",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Profession")
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
     *                  ref="#/components/schemas/Profession"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProfessionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Profession $profession */
        $profession = Profession::create($input);

        return $this->sendResponse(
            $profession->toArray(),
            __('messages.saved', ['model' => __('models/professions.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/professions/{idDomainActivity}",
     *      summary="getProfessionsByDomainWebSite",
     *      tags={"Profession"},
     *      description="Get Profession  By Domain Activity WebSite",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Profession",
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
     *                  ref="#/components/schemas/Profession"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getProfessionsByDomainWebSite($idDomainActivity): JsonResponse
    {
        $professions = Profession::where('domain_activities_id',$idDomainActivity)
            ->where('enable',1)
            ->get();

        return $this->sendResponse(
            $professions->toArray(),
            __('messages.retrieved', ['model' => __('models/professions.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/professions/{id}",
     *      summary="getProfessionItem",
     *      tags={"Profession"},
     *      description="Get Profession",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Profession",
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
     *                  ref="#/components/schemas/Profession"
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
        /** @var Profession $profession */
        $profession = Profession::find($id);

        if (empty($profession)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/professions.singular')])
            );
        }

        return $this->sendResponse(
            $profession->toArray(),
            __('messages.retrieved', ['model' => __('models/professions.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/professions/{id}",
     *      summary="updateProfession",
     *      tags={"Profession"},
     *      description="Update Profession",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Profession",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Profession")
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
     *                  ref="#/components/schemas/Profession"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProfessionAPIRequest $request): JsonResponse
    {
        /** @var Profession $profession */
        $profession = Profession::find($id);

        if (empty($profession)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/professions.singular')])
            );
        }

        $profession->fill($request->all());
        $profession->save();

        return $this->sendResponse(
            $profession->toArray(),
            __('messages.updated', ['model' => __('models/professions.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/professions/{id}",
     *      summary="deleteProfession",
     *      tags={"Profession"},
     *      description="Delete Profession",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Profession",
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
        /** @var Profession $profession */
        $profession = Profession::find($id);

        if (empty($profession)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/professions.singular')])
            );
        }

        $profession->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/professions.singular')])
        );
    }
}
