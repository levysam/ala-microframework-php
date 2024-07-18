<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleListBusiness;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use ResponseJson\ResponseJson;

class SampleListController extends BaseController
{
    private $sampleListBusiness;
    private $response;

    /**
     * constructor
     * @param SampleListBusiness $sampleListBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleListBusiness $sampleListBusiness,
        ResponseJson $response
    ) {
        $this->sampleListBusiness = $sampleListBusiness;
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
        $dataResponse = $this->sampleListBusiness->process(
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
