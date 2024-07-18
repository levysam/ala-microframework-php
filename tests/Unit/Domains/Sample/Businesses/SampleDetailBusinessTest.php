<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleDetailRepository;
use App\Exceptions\Custom\DataNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleDetailBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleDetailBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleDetailRepositorySpy = Mockery::spy(
            SampleDetailRepository::class
        );

        $sampleDetailBusiness = new SampleDetailBusiness(
            $sampleDetailRepositorySpy
        );

        $this->assertInstanceOf(
            SampleDetailBusiness::class,
            $sampleDetailBusiness
        );
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleDetailBusiness::process
     */
    public function testProcess()
    {
        $id = '01E4E7RTJ3C11B6Z0H0QTJCW04';

        $data = [
            'field' => 'test',
        ];

        $sampleDetailRepositoryMock = Mockery::mock(
            SampleDetailRepository::class
        )->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturn($data)
            ->getMock();

        $sampleDetailBusiness = Mockery::mock(
            SampleDetailBusiness::class,
            [
                $sampleDetailRepositoryMock,
            ]
        )->makePartial();

        $sampleDetailBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleDetailRepositoryMock)
            ->once()
            ->andReturn(true);

        $process = $sampleDetailBusiness->process(
            $id
        );

        $this->assertEquals($data, $process);
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleDetailBusiness::process
     */
    public function testProcessAndNotFound()
    {
        $id = '01E4E7K2Q6697S8SJVVFY5KCQ7';

        $sampleDetailRepositoryMock = Mockery::mock(
            SampleDetailRepository::class
        )->shouldReceive('getById')
            ->with($id)
            ->once()
            ->andReturn([])
            ->getMock();

        $sampleDetailBusiness = Mockery::mock(
            SampleDetailBusiness::class,
            [
                $sampleDetailRepositoryMock,
            ]
        )->makePartial();

        $sampleDetailBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleDetailRepositoryMock)
            ->once()
            ->andReturn(true);

        $this->expectExceptionObject(
            new DataNotFoundException(
                'Data not found',
                404
            )
        );

        $sampleDetailBusiness->process($id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
