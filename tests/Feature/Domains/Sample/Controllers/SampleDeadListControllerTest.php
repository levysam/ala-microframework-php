<?php

namespace Tests\Feature\Domains\Sample\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Feature\TestCaseFeature;

class SampleDeadListControllerTest extends TestCaseFeature
{
    use DatabaseMigrations;

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadListController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadListController::process
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::process
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
        $this->json('DELETE', '/sample/delete/' . $response['response']['id'], [], $this->header);
        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json('GET', '/sample/dead_list?page=1', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey(0, $response['response']['data']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadListController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadListController::process
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::process
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
        $this->json('DELETE', '/sample/delete/' . $response['response']['id'], [], $this->header);
        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json('GET', '/sample/dead_list?page=1&filter_field=eql,wrong', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey('data', $response['response']);
        $this->assertEquals([], $response['response']['data']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadListController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleDeadListController::process
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::process
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
        $this->json('DELETE', '/sample/delete/' . $response['response']['id'], [], $this->header);
        $response = json_decode($this->response->getContent(), true);

        sleep(1);
        $this->json('GET', '/sample/dead_list?page=1&filter_field=eql,test', [], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey(0, $response['response']['data']);
        $this->assertArrayHasKey('field', $response['response']['data'][0]);
        $this->assertEquals('test', $response['response']['data'][0]['field']);
    }
}
