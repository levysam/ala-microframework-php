<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleEditRepository;
use App\Exceptions\Custom\DataNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleEditBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleEditBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleEditRepositorySpy = Mockery::spy(
            SampleEditRepository::class
        );

        $sampleEditBusiness = new SampleEditBusiness(
            $sampleEditRepositorySpy
        );

        $this->assertInstanceOf(SampleEditBusiness::class, $sampleEditBusiness);
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleEditBusiness::process
     */
    public function testProcess()
    {
        $id = '01E4E7RTJ3C11B6Z0H0QTJCW04';

        $data = [
            'field' => 'test',
        ];

        $sampleEditRepositoryMock = Mockery::mock(
            SampleEditRepository::class
        )->shouldReceive('getById')
            ->with($id)
            ->twice()
            ->andReturn($data)
            ->shouldReceive('update')
            ->with($data, $id)
            ->once()
            ->andReturn(true)
            ->getMock();

        $sampleEditBusiness = Mockery::mock(
            SampleEditBusiness::class,
            [
                $sampleEditRepositoryMock,
            ]
        )->makePartial();

        $sampleEditBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleEditRepositoryMock)
            ->once()
            ->andReturn(true);

        $process = $sampleEditBusiness->process(
            $data,
            $id
        );

        $this->assertEquals($data, $process);
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleEditBusiness::process
     */
    public function testProcessAndNotFound()
    {
        $id = '01E4E7RTJ3C11B6Z0H0QTJCW04';

        $data = [
            'field' => 'test',
        ];

        $sampleEditRepositoryMock = Mockery::mock(
            SampleEditRepository::class
        )->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturn([])
            ->shouldReceive('update')
            ->never()
            ->andReturn(true)
            ->getMock();

        $sampleEditBusiness = Mockery::mock(
            SampleEditBusiness::class,
            [
                $sampleEditRepositoryMock,
            ]
        )->makePartial();

        $sampleEditBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleEditRepositoryMock)
            ->once()
            ->andReturn(true);

        $this->expectExceptionObject(
            new DataNotFoundException(
                'Data not found',
                404
            )
        );

        $sampleEditBusiness->process($data, $id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
