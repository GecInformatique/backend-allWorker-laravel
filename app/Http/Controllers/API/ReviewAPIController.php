<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReviewAPIRequest;
use App\Http\Requests\API\UpdateReviewAPIRequest;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ReviewController
 */

class ReviewAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/reviews",
     *      summary="getReviewList",
     *      tags={"Review"},
     *      description="Get all Reviews",
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
     *                  @OA\Items(ref="#/components/schemas/Review")
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
        $query = Review::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $reviews = $query->get();

        return $this->sendResponse(
            $reviews->toArray(),
            __('messages.retrieved', ['model' => __('models/reviews.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/reviews",
     *      summary="createReview",
     *      tags={"Review"},
     *      description="Create Review",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Review")
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
     *                  ref="#/components/schemas/Review"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReviewAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Review $review */
        $review = Review::create($input);

        return $this->sendResponse(
            $review->toArray(),
            __('messages.saved', ['model' => __('models/reviews.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/reviews/{id}",
     *      summary="getReviewItem",
     *      tags={"Review"},
     *      description="Get Review",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Review",
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
     *                  ref="#/components/schemas/Review"
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
        /** @var Review $review */
        $review = Review::find($id);

        if (empty($review)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/reviews.singular')])
            );
        }

        return $this->sendResponse(
            $review->toArray(),
            __('messages.retrieved', ['model' => __('models/reviews.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/reviews/{id}",
     *      summary="updateReview",
     *      tags={"Review"},
     *      description="Update Review",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Review",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Review")
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
     *                  ref="#/components/schemas/Review"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReviewAPIRequest $request): JsonResponse
    {
        /** @var Review $review */
        $review = Review::find($id);

        if (empty($review)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/reviews.singular')])
            );
        }

        $review->fill($request->all());
        $review->save();

        return $this->sendResponse(
            $review->toArray(),
            __('messages.updated', ['model' => __('models/reviews.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/reviews/{id}",
     *      summary="deleteReview",
     *      tags={"Review"},
     *      description="Delete Review",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Review",
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
        /** @var Review $review */
        $review = Review::find($id);

        if (empty($review)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/reviews.singular')])
            );
        }

        $review->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/reviews.singular')])
        );
    }
}
