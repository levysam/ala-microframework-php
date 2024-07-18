<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleDeadListBusiness;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use ResponseJson\ResponseJson;

class SampleDeadListController extends BaseController
{
    private $sampleDeadListBusiness;
    private $response;

    /**
     * constructor
     * @param SampleDeadListBusiness $sampleDeadListBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleDeadListBusiness $sampleDeadListBusiness,
        ResponseJson $response
    ) {
        $this->sampleDeadListBusiness = $sampleDeadListBusiness;
        $this->response = $response;
    }

    /**
     * process the request
     * @param Request $request
     * @return JsonObject
     */
    public function process(
        Request $request
    ) {
        $dataResponse = $this->sampleDeadListBusiness->process(
            $request->params->fields(),
            $request->params->order(),
            $request->params->classification(),
            $request->filters,
            $request->query()
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
