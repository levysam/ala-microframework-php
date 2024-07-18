<?php

namespace Tests\Feature\Domains\Sample\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Feature\TestCaseFeature;

class SampleEditControllerTest extends TestCaseFeature
{
    use DatabaseMigrations;

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleEditController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleEditController::process
     * @covers \App\Domains\Sample\Businesses\SampleEditBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleEditBusiness::process
     */
    public function testEditSample()
    {
        $data = [
            'field' => 'test',
        ];

        $this->json('POST', '/sample/add', $data, $this->header);
        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json(
            'PATCH',
            '/sample/edit/' . $response['response']['id'],
            ['field' => 'test 2'],
            $this->header
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('test 2', $response['response']['field']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleEditController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleEditController::process
     * @covers \App\Domains\Sample\Businesses\SampleEditBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleEditBusiness::process
     */
    public function testEditSampleNotFound()
    {
        $this->json(
            'PATCH',
            '/sample/edit/01E492KQX6BW62YEA45SGWRXYQ',
            ['field' => 'test 2'],
            $this->header
        );

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(404, $this->response->getStatusCode());
        $this->assertEquals('Data not found', $response['message']);
    }
}
