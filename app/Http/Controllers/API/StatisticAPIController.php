<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLogAPIRequest;
use App\Http\Requests\API\UpdateLogAPIRequest;
use App\Models\Candidate;
use App\Models\Log;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use function Doctrine\Common\Cache\Psr6\get;

/**
 * Class LogController
 */

class StatisticAPIController extends AppBaseController
{
    public function statsWebSite(Request $request): JsonResponse
    {
        $countFreelancers = Candidate::where('group_id', 5)->count();
        $countAllProject = Project::count();
        $countProjectFinish = Project::where('status', 'finish')
            ->whereNotNull('date_end')
            ->count();
        $countEmployers = Candidate::where('group_id', 7)->count();

        return $this->sendResponse(
            [
                "countFreelancers" => $countFreelancers + 200,
                "countAllProject" => $countAllProject + 110,
                "countProjectFinish" => $countProjectFinish +50,
                "countEmployers" => $countEmployers + 100,
            ],
            'Stats web site retrieved successfully'
        );
    }
}
