<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleAddBusiness;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use ResponseJson\ResponseJson;

class SampleAddController extends BaseController
{
    private $sampleAddBusiness;
    private $response;

    /**
     * constructor
     * @param SampleAddBusiness $sampleAddBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleAddBusiness $sampleAddBusiness,
        ResponseJson $response
    ) {
        $this->sampleAddBusiness = $sampleAddBusiness;
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

        $dataResponse = $this->sampleAddBusiness->process(
            $data
        );

        $result = $this->response->response(
            $request->requestId,
            $request->startProfile,
            $request->jwtToken,
            $dataResponse,
            ''
        );

        return response()->json(
            $result,
            201,
            [],
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        );
    }
}
