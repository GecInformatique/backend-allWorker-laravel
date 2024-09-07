<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProjectAPIRequest;
use App\Http\Requests\API\UpdateProjectAPIRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ProjectController
 */

class ProjectAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/projects",
     *      summary="getProjectList",
     *      tags={"Project"},
     *      description="Get all Projects",
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
     *                  @OA\Items(ref="#/components/schemas/Project")
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
        $query = Project::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $projects = $query->get();

        return $this->sendResponse(
            $projects->toArray(),
            __('messages.retrieved', ['model' => __('models/projects.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/project-with-display",
     *      summary="projectWithDisplay",
     *      tags={"Project"},
     *      description="Get all project With Display",
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
     *                  @OA\Items(ref="#/components/schemas/Project")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function projectWithDisplay(Request $request): JsonResponse
    {
        $query = Project::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $projects = $query->where("published_online","=",true)->get();

        return $this->sendResponse(
            $projects->toArray(),
            __('messages.retrieved', ['model' => __('models/projects.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/projects",
     *      summary="createProject",
     *      tags={"Project"},
     *      description="Create Project",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Project")
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
     *                  ref="#/components/schemas/Project"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProjectAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Project $project */
        $project = Project::create($input);

        return $this->sendResponse(
            $project->toArray(),
            __('messages.saved', ['model' => __('models/projects.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/projects/{id}",
     *      summary="getProjectItem",
     *      tags={"Project"},
     *      description="Get Project",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Project",
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
     *                  ref="#/components/schemas/Project"
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
        /** @var Project $project */
        $project = Project::find($id);

        if (empty($project)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/projects.singular')])
            );
        }

        return $this->sendResponse(
            $project->toArray(),
            __('messages.retrieved', ['model' => __('models/projects.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/projects/{id}",
     *      summary="updateProject",
     *      tags={"Project"},
     *      description="Update Project",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Project",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Project")
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
     *                  ref="#/components/schemas/Project"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProjectAPIRequest $request): JsonResponse
    {
        /** @var Project $project */
        $project = Project::find($id);

        if (empty($project)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/projects.singular')])
            );
        }

        $project->fill($request->all());
        $project->save();

        return $this->sendResponse(
            $project->toArray(),
            __('messages.updated', ['model' => __('models/projects.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/projects/{id}",
     *      summary="deleteProject",
     *      tags={"Project"},
     *      description="Delete Project",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Project",
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
        /** @var Project $project */
        $project = Project::find($id);

        if (empty($project)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/projects.singular')])
            );
        }

        $project->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/projects.singular')])
        );
    }
}
