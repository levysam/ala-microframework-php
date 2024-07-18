<?php

namespace Tests\Feature\Domains\Sample\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Feature\TestCaseFeature;

class SampleBulkControllerTest extends TestCaseFeature
{
    use DatabaseMigrations;

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleBulkController::__construct
     */
    public function testRequiredFields()
    {
        $this->json('POST', '/sample/bulk', [], $this->header);

        $response = [
            'message' => 'A validation error occurrs',
            'response' => [
                'ids' => [
                    'The ids field is required.'
                ],
            ]
        ];

        $result = json_decode($this->response->getContent(), true);

        $this->assertEquals(422, $this->response->getStatusCode());
        $this->assertEquals('A validation error occurrs', $result['message']);
        $this->assertEquals($response['response']['ids'], $result['response']['ids']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleBulkController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleBulkController::process
     * @covers \App\Domains\Sample\Businesses\SampleBulkBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleBulkBusiness::process
     */
    public function testBulk()
    {
        $data = [
            'field' => 'test',
        ];
        
        $this->call('options', '/sample/add', [], $this->header);
        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);
        $id = $response['response']['id'];
        $ids = [
            $id
        ];

        sleep(1);
        $this->json('POST', '/sample/bulk', ['ids' => $ids], $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey(0, $response['response']['data']);
        $this->assertEquals($id, $response['response']['data'][0]['id']);
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleBulkController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleBulkController::process
     * @covers \App\Domains\Sample\Businesses\SampleBulkBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleBulkBusiness::process
     */
    public function testBulkManyIds()
    {
        $data = [
            'field' => 'test',
        ];

        $ids = [];

        $this->call('options', '/sample/add', [], $this->header);
        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);
        $ids[] = $response['response']['id'];

        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);
        $ids[] = $response['response']['id'];

        sleep(1);
        $this->json('POST', '/sample/bulk', ['ids' => $ids], $this->header);

        $response = json_decode($this->response->getContent(), true);
        $responseIds = array_column($response['response']['data'], 'id');

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertArrayHasKey(0, $response['response']['data']);
        $this->assertArrayHasKey(1, $response['response']['data']);
        $this->assertContains($ids[0], $responseIds);
        $this->assertContains($ids[1], $responseIds);
    }
}
