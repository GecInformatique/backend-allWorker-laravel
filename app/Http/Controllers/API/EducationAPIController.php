<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEducationAPIRequest;
use App\Http\Requests\API\UpdateEducationAPIRequest;
use App\Models\Education;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class EducationController
 */

class EducationAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/education",
     *      summary="getEducationList",
     *      tags={"Education"},
     *      description="Get all Education",
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
     *                  @OA\Items(ref="#/components/schemas/Education")
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
        $query = Education::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $education = $query->get();

        return $this->sendResponse(
            $education->toArray(),
            __('messages.retrieved', ['model' => __('models/education.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/education",
     *      summary="createEducation",
     *      tags={"Education"},
     *      description="Create Education",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Education")
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
     *                  ref="#/components/schemas/Education"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEducationAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Education $education */
        $education = Education::create($input);

        return $this->sendResponse(
            $education->toArray(),
            __('messages.saved', ['model' => __('models/education.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/education/{id}",
     *      summary="getEducationItem",
     *      tags={"Education"},
     *      description="Get Education",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Education",
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
     *                  ref="#/components/schemas/Education"
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
        /** @var Education $education */
        $education = Education::find($id);

        if (empty($education)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/education.singular')])
            );
        }

        return $this->sendResponse(
            $education->toArray(),
            __('messages.retrieved', ['model' => __('models/education.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/education/{id}",
     *      summary="updateEducation",
     *      tags={"Education"},
     *      description="Update Education",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Education",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Education")
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
     *                  ref="#/components/schemas/Education"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEducationAPIRequest $request): JsonResponse
    {
        /** @var Education $education */
        $education = Education::find($id);

        if (empty($education)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/education.singular')])
            );
        }

        $education->fill($request->all());
        $education->save();

        return $this->sendResponse(
            $education->toArray(),
            __('messages.updated', ['model' => __('models/education.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/education/{id}",
     *      summary="deleteEducation",
     *      tags={"Education"},
     *      description="Delete Education",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Education",
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
        /** @var Education $education */
        $education = Education::find($id);

        if (empty($education)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/education.singular')])
            );
        }

        $education->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/education.singular')])
        );
    }
}
