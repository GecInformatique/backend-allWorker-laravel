<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCandidateAPIRequest;
use App\Http\Requests\API\UpdateCandidateAPIRequest;
use App\Models\Candidate;
use App\Models\CandidatesHasCompetence;
use App\Models\DomainActivity;
use App\Models\Profession;
use App\Models\Specialism;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CandidateController
 */

class CandidateAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/candidates",
     *      summary="getCandidateList",
     *      tags={"Candidate"},
     *      description="Get all Candidates",
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
     *                  @OA\Items(ref="#/components/schemas/Candidate")
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
        $query = Candidate::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $candidates = $query->get();

        return $this->sendResponse(
            $candidates->toArray(),
            __('messages.retrieved', ['model' => __('models/candidates.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/candidate-display-with-cat",
     *      summary="candidateDisplayWithCat",
     *      tags={"Candidate"},
     *      description="Get all candidate Display With Category",
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
     *                  @OA\Items(ref="#/components/schemas/Candidate")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function candidateDisplayWithCat(Request $request): JsonResponse
    {
        $query = Candidate::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        if ($request->get('group')) {
            $query->where("group_id","=",$request->get('group'));
        }

        $candidates = $query->where("published_online","=",true)
            ->where("profile_verify_by_admin","=",true)
            ->where("profile_update","=",false)
            ->with("group")
            ->with("specialism")
            ->withCount('tasks')
            ->get();

        return $this->sendResponse(
            $candidates->toArray(),
            __('messages.retrieved', ['model' => __('models/candidates.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/search-candidate",
     *      summary="searchCandidate",
     *      tags={"Candidate"},
     *      description="Get search Candidate",
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
     *                  @OA\Items(ref="#/components/schemas/Candidate")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function searchCandidate(Request $request): JsonResponse
    {
        $query = Candidate::query();
        $perPage = 10;

        if ($request->get('page')) {
            $skip = ($request->get('page') - 1) * $perPage;
            $query->skip($skip)->limit($perPage);
        }


        if ($request->get('group')) {
            $query->where("group_id", $request->get('group'));
        }

        if ($request->get('language')) {
            $query->where("language", $request->get('language'));
        }

        if ($request->get('typeDisponibility')) {
            $query->where("type_disponibility", $request->get('typeDisponibility'));
        }

        if ($request->get('searchKey')) {
            $searchKey = $request->get('searchKey');
            $query->where(function($q) use ($searchKey) {
                $q->where("full_name", "like", "%{$searchKey}%")
                    ->orWhere("owner_name", "like", "%{$searchKey}%")
                    ->orWhere("pseudo", "like", "%{$searchKey}%")
                    ->orWhere("city", "like", "%{$searchKey}%")
                    ->orWhere("nationality", "like", "%{$searchKey}%")
                    ->orWhere("complete_address", "like", "%{$searchKey}%");
            });
        }

        if ($request->get('competence')) {
            $candidatesWithCompetences = CandidatesHasCompetence::whereIn("competences_id", $request->get('competence'))->pluck("candidates_id");
            $query->whereIn("id", $candidatesWithCompetences);
        }

        if ($request->get('domainActivity')) {
            $professions = Profession::whereIn("domain_activities_id", $request->get('domainActivity'))->pluck("id");
            $specialisms = Specialism::whereIn("professions_id", $professions)->pluck("id");
            $query->whereIn("specialisms_id", $specialisms);
        }

        $candidates = $query->where("published_online", true)
            ->where("profile_verify_by_admin", true)
            ->where("profile_update", false)
            ->with(["group", "specialism", "competences"])
            ->paginate($perPage);

        return $this->sendResponse(
            $candidates,
            __('messages.retrieved', ['model' => __('models/candidates.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/candidates",
     *      summary="createCandidate",
     *      tags={"Candidate"},
     *      description="Create Candidate",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Candidate")
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
     *                  ref="#/components/schemas/Candidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCandidateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Candidate $candidate */
        $candidate = Candidate::create($input);

        return $this->sendResponse(
            $candidate->toArray(),
            __('messages.saved', ['model' => __('models/candidates.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/candidates/{id}",
     *      summary="getCandidateItem",
     *      tags={"Candidate"},
     *      description="Get Candidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Candidate",
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
     *                  ref="#/components/schemas/Candidate"
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
        /** @var Candidate $candidate */
        $candidate = Candidate::find($id);

        if (empty($candidate)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/candidates.singular')])
            );
        }

        return $this->sendResponse(
            $candidate->toArray(),
            __('messages.retrieved', ['model' => __('models/candidates.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/candidates/{id}",
     *      summary="updateCandidate",
     *      tags={"Candidate"},
     *      description="Update Candidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Candidate",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Candidate")
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
     *                  ref="#/components/schemas/Candidate"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCandidateAPIRequest $request): JsonResponse
    {
        /** @var Candidate $candidate */
        $candidate = Candidate::find($id);

        if (empty($candidate)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/candidates.singular')])
            );
        }

        $candidate->fill($request->all());
        $candidate->save();

        return $this->sendResponse(
            $candidate->toArray(),
            __('messages.updated', ['model' => __('models/candidates.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/candidates/{id}",
     *      summary="deleteCandidate",
     *      tags={"Candidate"},
     *      description="Delete Candidate",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Candidate",
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
        /** @var Candidate $candidate */
        $candidate = Candidate::find($id);

        if (empty($candidate)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/candidates.singular')])
            );
        }

        $candidate->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/candidates.singular')])
        );
    }
}
