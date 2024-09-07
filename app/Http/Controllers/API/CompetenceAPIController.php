<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompetenceAPIRequest;
use App\Http\Requests\API\UpdateCompetenceAPIRequest;
use App\Models\Competence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CompetenceController
 */

class CompetenceAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/competences",
     *      summary="getCompetenceList",
     *      tags={"Competence"},
     *      description="Get all Competences",
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
     *                  @OA\Items(ref="#/components/schemas/Competence")
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
        $query = Competence::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $competences = $query->get();

        return $this->sendResponse(
            $competences->toArray(),
            __('messages.retrieved', ['model' => __('models/competences.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/competences",
     *      summary="getCompetenceListWebSite",
     *      tags={"Competence"},
     *      description="Get all Competence List WebSite",
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
     *                  @OA\Items(ref="#/components/schemas/Competence")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getCompetenceListWebSite(Request $request): JsonResponse
    {
        $query = Competence::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $competences = $query->where('enable',"=",1)->get();

        return $this->sendResponse(
            $competences->toArray(),
            __('messages.retrieved', ['model' => __('models/competences.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/competences",
     *      summary="createCompetence",
     *      tags={"Competence"},
     *      description="Create Competence",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Competence")
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
     *                  ref="#/components/schemas/Competence"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCompetenceAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Competence $competence */
        $competence = Competence::create($input);

        return $this->sendResponse(
            $competence->toArray(),
            __('messages.saved', ['model' => __('models/competences.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/competences/{id}",
     *      summary="getCompetenceItem",
     *      tags={"Competence"},
     *      description="Get Competence",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Competence",
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
     *                  ref="#/components/schemas/Competence"
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
        /** @var Competence $competence */
        $competence = Competence::find($id);

        if (empty($competence)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/competences.singular')])
            );
        }

        return $this->sendResponse(
            $competence->toArray(),
            __('messages.retrieved', ['model' => __('models/competences.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/competences/{id}",
     *      summary="updateCompetence",
     *      tags={"Competence"},
     *      description="Update Competence",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Competence",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Competence")
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
     *                  ref="#/components/schemas/Competence"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCompetenceAPIRequest $request): JsonResponse
    {
        /** @var Competence $competence */
        $competence = Competence::find($id);

        if (empty($competence)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/competences.singular')])
            );
        }

        $competence->fill($request->all());
        $competence->save();

        return $this->sendResponse(
            $competence->toArray(),
            __('messages.updated', ['model' => __('models/competences.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/competences/{id}",
     *      summary="deleteCompetence",
     *      tags={"Competence"},
     *      description="Delete Competence",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Competence",
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
        /** @var Competence $competence */
        $competence = Competence::find($id);

        if (empty($competence)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/competences.singular')])
            );
        }

        $competence->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/competences.singular')])
        );
    }
}
