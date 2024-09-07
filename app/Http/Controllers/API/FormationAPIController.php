<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateFormationAPIRequest;
use App\Http\Requests\API\UpdateFormationAPIRequest;
use App\Models\Formation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class FormationController
 */

class FormationAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/formations",
     *      summary="getFormationList",
     *      tags={"Formation"},
     *      description="Get all Formations",
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
     *                  @OA\Items(ref="#/components/schemas/Formation")
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
        $query = Formation::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $formations = $query->get();

        return $this->sendResponse(
            $formations->toArray(),
            __('messages.retrieved', ['model' => __('models/formations.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/formations",
     *      summary="formationWebSite",
     *      tags={"Formation"},
     *      description="Get all formationWebSite",
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
     *                  @OA\Items(ref="#/components/schemas/Formation")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function formationWebSite(Request $request): JsonResponse
    {
        $query = Formation::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        if ($request->get('category')) {
            $query->where("domain_activities_id","=",$request->get('category'));
        }

        $formations = $query->with("domainActivity")->paginate(6);

        return $this->sendResponse(
            $formations,
            __('messages.retrieved', ['model' => __('models/formations.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/formations",
     *      summary="createFormation",
     *      tags={"Formation"},
     *      description="Create Formation",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Formation")
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
     *                  ref="#/components/schemas/Formation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFormationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Formation $formation */
        $formation = Formation::create($input);

        return $this->sendResponse(
            $formation->toArray(),
            __('messages.saved', ['model' => __('models/formations.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/formations/{id}",
     *      summary="getFormationItem",
     *      tags={"Formation"},
     *      description="Get Formation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Formation",
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
     *                  ref="#/components/schemas/Formation"
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
        /** @var Formation $formation */
        $formation = Formation::find($id);

        if (empty($formation)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/formations.singular')])
            );
        }

        return $this->sendResponse(
            $formation->toArray(),
            __('messages.retrieved', ['model' => __('models/formations.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/formations/{id}",
     *      summary="updateFormation",
     *      tags={"Formation"},
     *      description="Update Formation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Formation",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Formation")
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
     *                  ref="#/components/schemas/Formation"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFormationAPIRequest $request): JsonResponse
    {
        /** @var Formation $formation */
        $formation = Formation::find($id);

        if (empty($formation)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/formations.singular')])
            );
        }

        $formation->fill($request->all());
        $formation->save();

        return $this->sendResponse(
            $formation->toArray(),
            __('messages.updated', ['model' => __('models/formations.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/formations/{id}",
     *      summary="deleteFormation",
     *      tags={"Formation"},
     *      description="Delete Formation",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Formation",
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
        /** @var Formation $formation */
        $formation = Formation::find($id);

        if (empty($formation)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/formations.singular')])
            );
        }

        $formation->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/formations.singular')])
        );
    }
}
