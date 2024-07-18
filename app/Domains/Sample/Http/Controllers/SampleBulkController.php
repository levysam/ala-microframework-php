<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleBulkBusiness;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use ResponseJson\ResponseJson;

class SampleBulkController extends BaseController
{
    private $sampleBulkBusiness;
    private $response;

    /**
     * constructor
     * @param SampleBulkBusiness $sampleBulkBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleBulkBusiness $sampleBulkBusiness,
        ResponseJson $response
    ) {
        $this->sampleBulkBusiness = $sampleBulkBusiness;
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
        $data = $request->only($request->validFields);
        $data = $this->clearArrayFields($data);
        $ids = $data['ids'];

        $dataResponse = $this->sampleBulkBusiness->process(
            $ids,
            $request->params->fields(),
            $request->params->order(),
            $request->params->classification(),
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
