<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTestimonialAPIRequest;
use App\Http\Requests\API\UpdateTestimonialAPIRequest;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class TestimonialController
 */

class TestimonialAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/testimonials",
     *      summary="getTestimonialList",
     *      tags={"Testimonial"},
     *      description="Get all Testimonials",
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
     *                  @OA\Items(ref="#/components/schemas/Testimonial")
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
        $query = Testimonial::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $testimonials = $query->get();

        return $this->sendResponse(
            $testimonials->toArray(),
            __('messages.retrieved', ['model' => __('models/testimonials.plural')])
        );
    }

    /**
     * @OA\Get(
     *      path="/website/testimonials",
     *      summary="testimonialWebSite",
     *      tags={"Testimonial"},
     *      description="Get all testimonial Web Site",
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
     *                  @OA\Items(ref="#/components/schemas/Testimonial")
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function testimonialWebSite(Request $request): JsonResponse
    {
        $query = Testimonial::query();

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $testimonials = $query->get();

        return $this->sendResponse(
            $testimonials->toArray(),
            __('messages.retrieved', ['model' => __('models/testimonials.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/testimonials",
     *      summary="createTestimonial",
     *      tags={"Testimonial"},
     *      description="Create Testimonial",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Testimonial")
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
     *                  ref="#/components/schemas/Testimonial"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTestimonialAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Testimonial $testimonial */
        $testimonial = Testimonial::create($input);

        return $this->sendResponse(
            $testimonial->toArray(),
            __('messages.saved', ['model' => __('models/testimonials.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/testimonials/{id}",
     *      summary="getTestimonialItem",
     *      tags={"Testimonial"},
     *      description="Get Testimonial",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Testimonial",
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
     *                  ref="#/components/schemas/Testimonial"
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
        /** @var Testimonial $testimonial */
        $testimonial = Testimonial::find($id);

        if (empty($testimonial)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/testimonials.singular')])
            );
        }

        return $this->sendResponse(
            $testimonial->toArray(),
            __('messages.retrieved', ['model' => __('models/testimonials.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/testimonials/{id}",
     *      summary="updateTestimonial",
     *      tags={"Testimonial"},
     *      description="Update Testimonial",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Testimonial",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Testimonial")
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
     *                  ref="#/components/schemas/Testimonial"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTestimonialAPIRequest $request): JsonResponse
    {
        /** @var Testimonial $testimonial */
        $testimonial = Testimonial::find($id);

        if (empty($testimonial)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/testimonials.singular')])
            );
        }

        $testimonial->fill($request->all());
        $testimonial->save();

        return $this->sendResponse(
            $testimonial->toArray(),
            __('messages.updated', ['model' => __('models/testimonials.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/testimonials/{id}",
     *      summary="deleteTestimonial",
     *      tags={"Testimonial"},
     *      description="Delete Testimonial",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Testimonial",
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
        /** @var Testimonial $testimonial */
        $testimonial = Testimonial::find($id);

        if (empty($testimonial)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/testimonials.singular')])
            );
        }

        $testimonial->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/testimonials.singular')])
        );
    }
}
