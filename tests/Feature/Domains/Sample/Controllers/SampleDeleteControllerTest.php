<?php

namespace Tests\Feature\Domains\Sample\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Feature\TestCaseFeature;

class SampleDeleteControllerTest extends TestCaseFeature
{
    use DatabaseMigrations;

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeleteController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeleteController::process
     * @covers \App\Domains\Sample\Businesses\SampleDeleteBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleDeleteBusiness::process
     */
    public function testDelete()
    {
        $data = [
            'field' => 'test',
        ];

        $this->json('POST', '/sample/add', $data, $this->header);
        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->delete('/sample/delete/' . $response['response']['id'], [], $this->header);

        $this->assertEquals(204, $this->response->getStatusCode());
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeleteController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeleteController::process
     * @covers \App\Domains\Sample\Businesses\SampleDeleteBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleDeleteBusiness::process
     */
    public function testDeleteAndNotFound()
    {
        $this->json('DELETE', '/sample/delete/01E492KQX6BW62YEA45SGWRXYQ', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(404, $this->response->getStatusCode());
        $this->assertEquals('Data not found', $response['message']);
    }
}
