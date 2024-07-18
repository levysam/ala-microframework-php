<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleDeadDetailBusiness;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use ResponseJson\ResponseJson;

class SampleDeadDetailController extends BaseController
{
    private $sampleDeadDetailBusiness;
    private $response;

     /**
     * constructor
     * @param SampleDeadDetailBusiness $sampleDeadDetailBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleDeadDetailBusiness $sampleDeadDetailBusiness,
        ResponseJson $response
    ) {
        $this->sampleDeadDetailBusiness = $sampleDeadDetailBusiness;
        $this->response = $response;
    }

    /**
     * process the request
     * @param string $id
     * @param Request $request
     * @return JsonObject
     */
    public function process(
        string $id,
        Request $request
    ) {
        $dataResponse = $this->sampleDeadDetailBusiness->process(
            $id
        );

        $result = $this->response->response(
            $request->requestId,
            $request->startProfile,
            $request->jwtToken,
            $dataResponse
        );

        return response()->json(
            $result,
            200,
            [],
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        );
    }
}
