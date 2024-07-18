<?php

namespace App\Domains\Sample\Http\Controllers;

use App\Domains\Sample\Businesses\SampleDeleteBusiness;
use App\Http\Controllers\BaseController;
use ResponseJson\ResponseJson;

class SampleDeleteController extends BaseController
{
    private $sampleDeleteBusiness;
    private $response;

    /**
     * constructor
     * @param SampleDeleteBusiness $sampleDeleteBusiness
     * @param ResponseJson $response
     * @return void
     */
    public function __construct(
        SampleDeleteBusiness $sampleDeleteBusiness,
        ResponseJson $response
    ) {
        $this->sampleDeleteBusiness = $sampleDeleteBusiness;
        $this->response = $response;
    }

    /**
     * process the request
     * @param string $id
     * @return JsonObject
     */
    public function process(
        string $id
    ) {
        $this->sampleDeleteBusiness->process(
            $id
        );

        $result = $this->response->responseDelete();

        return response()->json(
            $result,
            204,
            [],
            JSON_UNESCAPED_SLASHES |
            JSON_UNESCAPED_UNICODE
        );
    }
}
