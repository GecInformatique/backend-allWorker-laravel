<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuestionAPIRequest;
use App\Http\Requests\API\UpdateQuestionAPIRequest;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class QuestionController
 */

class QuestionAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/questions",
     *      summary="getQuestionList",
     *      tags={"Question"},
     *      description="Get all Questions",
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
     *                  @OA\Items(ref="#/components/schemas/Question")
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
        $query = Question::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $questions = $query->get();

        return $this->sendResponse(
            $questions->toArray(),
            __('messages.retrieved', ['model' => __('models/questions.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/questions",
     *      summary="questionWebSite",
     *      tags={"Question"},
     *      description="Get all questionWebSite",
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
     *                  @OA\Items(ref="#/components/schemas/Question")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function questionWebSite(Request $request): JsonResponse
    {
        $query = Question::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $questions = $query->get();

        return $this->sendResponse(
            $questions->toArray(),
            __('messages.retrieved', ['model' => __('models/questions.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/questions",
     *      summary="createQuestion",
     *      tags={"Question"},
     *      description="Create Question",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Question")
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
     *                  ref="#/components/schemas/Question"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateQuestionAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Question $question */
        $question = Question::create($input);

        return $this->sendResponse(
            $question->toArray(),
            __('messages.saved', ['model' => __('models/questions.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/questions/{id}",
     *      summary="getQuestionItem",
     *      tags={"Question"},
     *      description="Get Question",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Question",
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
     *                  ref="#/components/schemas/Question"
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
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/questions.singular')])
            );
        }

        return $this->sendResponse(
            $question->toArray(),
            __('messages.retrieved', ['model' => __('models/questions.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/questions/{id}",
     *      summary="updateQuestion",
     *      tags={"Question"},
     *      description="Update Question",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Question",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Question")
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
     *                  ref="#/components/schemas/Question"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateQuestionAPIRequest $request): JsonResponse
    {
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/questions.singular')])
            );
        }

        $question->fill($request->all());
        $question->save();

        return $this->sendResponse(
            $question->toArray(),
            __('messages.updated', ['model' => __('models/questions.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/questions/{id}",
     *      summary="deleteQuestion",
     *      tags={"Question"},
     *      description="Delete Question",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Question",
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
        /** @var Question $question */
        $question = Question::find($id);

        if (empty($question)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/questions.singular')])
            );
        }

        $question->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/questions.singular')])
        );
    }
}
