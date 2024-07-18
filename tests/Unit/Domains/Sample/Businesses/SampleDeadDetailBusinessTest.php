<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleDeadDetailRepository;
use App\Exceptions\Custom\DataNotFoundException;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleDeadDetailBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeadDetailBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleDeadDetailRepositorySpy = Mockery::spy(
            SampleDeadDetailRepository::class
        );

        $sampleDeadDetailBusiness = new SampleDeadDetailBusiness(
            $sampleDeadDetailRepositorySpy
        );

        $this->assertInstanceOf(
            SampleDeadDetailBusiness::class,
            $sampleDeadDetailBusiness
        );
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeadDetailBusiness::process
     */
    public function testProcess()
    {
        $id = '01E4KKE1VK2P2FWYVGPTANVFMM';

        $data = [
            'field' => 'test',
        ];

        $sampleDeadDetailRepositoryMock = Mockery::mock(
            SampleDeadDetailRepository::class
        )->shouldReceive('getDeadById')
            ->with($id)
            ->once()
            ->andReturn($data)
            ->getMock();

        $sampleDeadDetailBusiness = Mockery::mock(
            SampleDeadDetailBusiness::class,
            [
                $sampleDeadDetailRepositoryMock,
            ]
        )->makePartial();

        $sampleDeadDetailBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleDeadDetailRepositoryMock)
            ->once()
            ->andReturn(true);

        $process = $sampleDeadDetailBusiness->process(
            $id
        );

        $this->assertEquals($data, $process);
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeadDetailBusiness::process
     */
    public function testProcessAndNotFound()
    {
        $id = '01E4KKE1VK2P2FWYVGPTANVFMM';

        $sampleDeadDetailRepositoryMock = Mockery::mock(
            SampleDeadDetailRepository::class
        )->shouldReceive('getDeadById')
            ->with($id)
            ->once()
            ->andReturn([])
            ->getMock();

        $sampleDeadDetailBusiness = Mockery::mock(
            SampleDeadDetailBusiness::class,
            [
                $sampleDeadDetailRepositoryMock,
            ]
        )->makePartial();

        $sampleDeadDetailBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleDeadDetailRepositoryMock)
            ->once()
            ->andReturn(true);

        $this->expectExceptionObject(
            new DataNotFoundException(
                'Data not found',
                404
            )
        );

        $sampleDeadDetailBusiness->process($id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
