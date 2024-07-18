<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleDeleteRepository;
use App\Exceptions\Custom\DataNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleDeleteBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeleteBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleDeleteRepositorySpy = Mockery::spy(
            SampleDeleteRepository::class
        );

        $sampleDeleteBusiness = new SampleDeleteBusiness(
            $sampleDeleteRepositorySpy
        );

        $this->assertInstanceOf(
            SampleDeleteBusiness::class,
            $sampleDeleteBusiness
        );
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeleteBusiness::process
     */
    public function testProcess()
    {
        $id = '01E4E7RTJ3C11B6Z0H0QTJCW04';

        $data = [
            'field' => 'test',
        ];

        $sampleDeleteRepositoryMock = Mockery::mock(
            SampleDeleteRepository::class
        )->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturn($data)
            ->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturn(true)
            ->getMock();

        $sampleDeleteBusiness = Mockery::mock(
            SampleDeleteBusiness::class,
            [
                $sampleDeleteRepositoryMock,
            ]
        )->makePartial();

        $sampleDeleteBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleDeleteRepositoryMock)
            ->once()
            ->andReturn(true);

        $process = $sampleDeleteBusiness->process(
            $id
        );

        $this->assertEquals($process, true);
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeleteBusiness::process
     */
    public function testProcessAndNotFound()
    {
        $id = '01E4E70YSH4J9C0JP8YRJ8SF17';

        $sampleDeleteRepositoryMock = Mockery::mock(
            SampleDeleteRepository::class
        )->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturn([])
            ->shouldReceive('delete')
            ->never()
            ->andReturn(true)
            ->getMock();

        $sampleDeleteBusiness = Mockery::mock(
            SampleDeleteBusiness::class,
            [
                $sampleDeleteRepositoryMock,
            ]
        )->makePartial();

        $sampleDeleteBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleDeleteRepositoryMock)
            ->once()
            ->andReturn(true);

        $this->expectExceptionObject(
            new DataNotFoundException(
                'Data not found',
                404
            )
        );

        $sampleDeleteBusiness->process(
            $id
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
