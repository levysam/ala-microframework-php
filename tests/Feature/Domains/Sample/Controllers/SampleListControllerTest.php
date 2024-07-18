<?php

namespace Tests\Feature\Domains\Sample\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Feature\TestCaseFeature;

class SampleListControllerTest extends TestCaseFeature
{
    use DatabaseMigrations;

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleListController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleListController::process
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::process
     */
    public function testList()
    {
        $data = [
            'field' => 'test',
        ];

        $this->call('options', '/sample/add', [], $this->header);
        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json('GET', '/sample/list', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey(0, $response['response']['data']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleListController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleListController::process
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::process
     */
    public function testListWithFilterNotFound()
    {
        $data = [
            'field' => 'test',
        ];

        $this->call('options', '/sample/add', [], $this->header);
        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json('GET', '/sample/list?filter_field=eql,wrong', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey('data', $response['response']);
        $this->assertEquals([], $response['response']['data']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleListController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleListController::process
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::process
     */
    public function testListWithFilterFound()
    {
        $data = [
            'field' => 'test',
        ];

        $this->call('options', '/sample/add', [], $this->header);
        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json('GET', '/sample/list?filter_field=eql,test', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey(0, $response['response']['data']);
        $this->assertArrayHasKey('field', $response['response']['data'][0]);
        $this->assertEquals('test', $response['response']['data'][0]['field']);
    }
}
