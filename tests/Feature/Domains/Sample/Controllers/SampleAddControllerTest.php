<?php

namespace Tests\Feature\Domains\Sample\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\Feature\TestCaseFeature;

class SampleAddControllerTest extends TestCaseFeature
{
    use DatabaseMigrations;

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleAddController::__construct
     */
    public function testRequiredFields()
    {
        $this->json('POST', '/sample/add', [], $this->header);

        $response = [
            'message' => 'A validation error occurrs',
            'response' => [
                'field' => [
                    'The field field is required.'
                ],
            ]
        ];

        $result = json_decode($this->response->getContent(), true);

        $this->assertEquals(422, $this->response->getStatusCode());
        $this->assertArrayHasKey('message', $result);
        $this->assertEquals('A validation error occurrs', $result['message']);
        $fields = [
            'field',
        ];
        foreach ($fields as $field) {
            $this->assertEquals($response['response'][$field], $result['response'][$field]);
        }
    }

    /**
     * @covers \App\Domains\Sample\Http\Controllers\SampleAddController::__construct
     * @covers \App\Domains\Sample\Http\Controllers\SampleAddController::process
     * @covers \App\Domains\Sample\Businesses\SampleAddBusiness::__construct
     * @covers \App\Domains\Sample\Businesses\SampleAddBusiness::process
     */
    public function testAddSample()
    {
        $data = [
            'field' => 'test',
        ];

        $this->call('options', '/sample/add', [], $this->header);
        $this->json('POST', '/sample/add', $data, $this->header);

        $response = json_decode($this->response->getContent(), true);

        $this->assertEquals(201, $this->response->getStatusCode());
        $this->assertEquals($data['field'], $response['response']['field']);
    }
}
