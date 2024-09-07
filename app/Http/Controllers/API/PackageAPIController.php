<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePackageAPIRequest;
use App\Http\Requests\API\UpdatePackageAPIRequest;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PackageController
 */

class PackageAPIController extends AppBaseController
{
    /**
     * @OA\Get(
     *      path="/packages",
     *      summary="getPackageList",
     *      tags={"Package"},
     *      description="Get all Packages",
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
     *                  @OA\Items(ref="#/components/schemas/Package")
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
        $query = Package::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $packages = $query->get();

        return $this->sendResponse(
            $packages->toArray(),
            __('messages.retrieved', ['model' => __('models/packages.plural')])
        );
    }

    /**
     * @OA\Post(
     *      path="/packages",
     *      summary="createPackage",
     *      tags={"Package"},
     *      description="Create Package",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Package")
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
     *                  ref="#/components/schemas/Package"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePackageAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Package $package */
        $package = Package::create($input);

        return $this->sendResponse(
            $package->toArray(),
            __('messages.saved', ['model' => __('models/packages.singular')])
        );
    }

    /**
     * @OA\Get(
     *      path="/packages/{id}",
     *      summary="getPackageItem",
     *      tags={"Package"},
     *      description="Get Package",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Package",
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
     *                  ref="#/components/schemas/Package"
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
        /** @var Package $package */
        $package = Package::find($id);

        if (empty($package)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/packages.singular')])
            );
        }

        return $this->sendResponse(
            $package->toArray(),
            __('messages.retrieved', ['model' => __('models/packages.singular')])
        );
    }

    /**
     * @OA\Put(
     *      path="/packages/{id}",
     *      summary="updatePackage",
     *      tags={"Package"},
     *      description="Update Package",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Package",
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Package")
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
     *                  ref="#/components/schemas/Package"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePackageAPIRequest $request): JsonResponse
    {
        /** @var Package $package */
        $package = Package::find($id);

        if (empty($package)) {
            return $this->sendError(
            __('messages.not_found', ['model' => __('models/packages.singular')])
            );
        }

        $package->fill($request->all());
        $package->save();

        return $this->sendResponse(
            $package->toArray(),
            __('messages.updated', ['model' => __('models/packages.singular')])
        );
    }

    /**
     * @OA\Delete(
     *      path="/packages/{id}",
     *      summary="deletePackage",
     *      tags={"Package"},
     *      description="Delete Package",
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Package",
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
        /** @var Package $package */
        $package = Package::find($id);

        if (empty($package)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/packages.singular')])
            );
        }

        $package->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/packages.singular')])
        );
    }
}
