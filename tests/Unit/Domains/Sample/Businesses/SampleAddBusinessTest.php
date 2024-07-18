<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleAddRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleAddBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleAddBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleAddRepositorySpy = Mockery::spy(
            SampleAddRepository::class
        );

        $sampleAddBusiness = new SampleAddBusiness(
            $sampleAddRepositorySpy
        );

        $this->assertInstanceOf(
            SampleAddBusiness::class,
            $sampleAddBusiness
        );
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleAddBusiness::process
     */
    public function testProcess()
    {
        $id = '01E4E7RTJ3C11B6Z0H0QTJCW04';
        
        $data = [
            'field' => 'test',
        ];

        $sampleAddRepositoryMock = Mockery::mock(
            SampleAddRepository::class
        )->shouldReceive('insert')
            ->with($data)
            ->once()
            ->andReturn($id)
            ->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturn($data)
            ->getMock();

        $sampleAddBusiness = Mockery::mock(
            SampleAddBusiness::class,
            [
                $sampleAddRepositoryMock,
            ]
        )->makePartial();

        $sampleAddBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleAddRepositoryMock)
            ->once()
            ->andReturn(true);

        $process = $sampleAddBusiness->process($data);

        $this->assertEquals($data, $process);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
