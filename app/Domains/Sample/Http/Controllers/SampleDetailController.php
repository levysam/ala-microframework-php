<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleDetailBusiness;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use ResponseJson\ResponseJson;

class SampleDetailController extends BaseController
{
    private $sampleDetailBusiness;
    private $response;

    /**
     * constructor
     * @param SampleDetailBusiness $sampleDetailBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleDetailBusiness $sampleDetailBusiness,
        ResponseJson $response
    ) {
        $this->sampleDetailBusiness = $sampleDetailBusiness;
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
        $dataResponse = $this->sampleDetailBusiness->process(
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
