<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleEditBusiness;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use ResponseJson\ResponseJson;

class SampleEditController extends BaseController
{
    private $sampleEditBusiness;
    private $response;

    /**
     * constructor
     * @param SampleEditBusiness $sampleEditBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleEditBusiness $sampleEditBusiness,
        ResponseJson $response
    ) {
        $this->sampleEditBusiness = $sampleEditBusiness;
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
        $data = $request->only($request->validFields);
        $data = $this->clearArrayFields($data);
        $dataResponse = $this->sampleEditBusiness->process(
            $data,
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
