<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateDomainActivityAPIRequest;
use App\Http\Requests\API\UpdateDomainActivityAPIRequest;
use App\Models\DomainActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class DomainActivityController
 */

class DomainActivityAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/domain-activities",
     *      summary="getDomainActivityList",
     *      tags={"DomainActivity"},
     *      description="Get all DomainActivities",
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
     *                  @OA\Items(ref="#/components/schemas/DomainActivity")
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
        $query = DomainActivity::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $domainActivities = $query->get();

        return $this->sendResponse(
            $domainActivities->toArray(),
            __('messages.retrieved', ['model' => __('models/domainActivities.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/domain-activities",
     *      summary="domainActivitiesWithCount",
     *      tags={"DomainActivity"},
     *      description="Get all Domain Activities With Count ",
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
     *                  @OA\Items(ref="#/components/schemas/DomainActivity")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function domainActivitiesWithCount(Request $request): JsonResponse
    {
        $query = DomainActivity::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $domainActivities = $query->where('enable',"=",1)->withCount('professions')->get();

        return $this->sendResponse(
            $domainActivities->toArray(),
            __('messages.retrieved', ['model' => __('models/domainActivities.plural')])
        );
    }


    /**
     * @OA\Post(
     *      path="/domain-activities",
     *      summary="createDomainActivity",
     *      tags={"DomainActivity"},
     *      description="Create DomainActivity",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/DomainActivity")
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
     *                  ref="#/components/schemas/DomainActivity"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateDomainActivityAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var DomainActivity $domainActivity */
        $domainActivity = DomainActivity::create($input);

        return $this->sendResponse(
            $domainActivity->toArray(),
            __('messages.saved', ['model' => __('models/domainActivities.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/domain-activities/{id}",
     *      summary="getDomainActivityItem",
     *      tags={"DomainActivity"},
     *      description="Get DomainActivity",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of DomainActivity",
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
     *                  ref="#/components/schemas/DomainActivity"
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
        /** @var DomainActivity $domainActivity */
        $domainActivity = DomainActivity::find($id);

        if (empty($domainActivity)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/domainActivities.singular')])
            );
        }

        return $this->sendResponse(
            $domainActivity->toArray(),
            __('messages.retrieved', ['model' => __('models/domainActivities.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/domain-activities/{id}",
     *      summary="updateDomainActivity",
     *      tags={"DomainActivity"},
     *      description="Update DomainActivity",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of DomainActivity",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/DomainActivity")
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
     *                  ref="#/components/schemas/DomainActivity"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateDomainActivityAPIRequest $request): JsonResponse
    {
        /** @var DomainActivity $domainActivity */
        $domainActivity = DomainActivity::find($id);

        if (empty($domainActivity)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/domainActivities.singular')])
            );
        }

        $domainActivity->fill($request->all());
        $domainActivity->save();

        return $this->sendResponse(
            $domainActivity->toArray(),
            __('messages.updated', ['model' => __('models/domainActivities.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/domain-activities/{id}",
     *      summary="deleteDomainActivity",
     *      tags={"DomainActivity"},
     *      description="Delete DomainActivity",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of DomainActivity",
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
        /** @var DomainActivity $domainActivity */
        $domainActivity = DomainActivity::find($id);

        if (empty($domainActivity)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/domainActivities.singular')])
            );
        }

        $domainActivity->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/domainActivities.singular')])
        );
    }
}
