<?php

namespace Tests\Feature\Domains\Sample\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Feature\TestCaseFeature;

class SampleDeadDetailControllerTest extends TestCaseFeature
{
    use DatabaseMigrations;

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadDetailController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadDetailController::process
     * @covers \App\Domains\Sample\Businesses\SampleDeadDetailBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleDeadDetailBusiness::process
     */
    public function testDetail()
    {
        $data = [
            'field' => 'test',
        ];

        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json('DELETE', '/sample/delete/' . $response['response']['id'], [], $this->header);
        sleep(1);
        $this->json('GET', '/sample/dead_detail/' . $response['response']['id'], [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals($data['field'], $response['response']['field']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadDetailController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadDetailController::process
     * @covers \App\Domains\Sample\Businesses\SampleDeadDetailBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleDeadDetailBusiness::process
     */
    public function testDetailNotFound()
    {
        $this->json('GET', '/sample/dead_detail/01E492KQX6BW62YEA45SGWRXYQ', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(404, $this->response->getStatusCode());
        $this->assertEquals('Data not found', $response['message']);
    }
}
