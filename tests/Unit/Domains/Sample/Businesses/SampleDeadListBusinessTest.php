<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleDeadListRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleDeadListBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleDeadListRepositorySpy = Mockery::spy(
            SampleDeadListRepository::class
        );

        $sampleDeadListBusiness = new SampleDeadListBusiness(
            $sampleDeadListRepositorySpy
        );

        $this->assertInstanceOf(
            SampleDeadListBusiness::class,
            $sampleDeadListBusiness
        );
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleDeadListBusiness::process
     */
    public function testProcess()
    {
        $data = [
            'id' => '01E4E7RTJ3C11B6Z0H0QTJCW04',
            'field' => 'teste',
        ];

        $sampleDeadListRepositoryMock = Mockery::mock(
            SampleDeadListRepository::class
        )->shouldReceive('getList')
            ->withAnyArgs()
            ->once()
            ->andReturn($data)
            ->getMock();

        $sampleDeadListBusiness = Mockery::mock(
            SampleDeadListBusiness::class,
            [
                $sampleDeadListRepositoryMock,
            ]
        )->makePartial();

        $sampleDeadListBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleDeadListRepositoryMock)
            ->once()
            ->andReturn(true);

        $process = $sampleDeadListBusiness->process(
            ['id', 'field'],
            '',
            '',
            null,
            []
        );

        $this->assertEquals($data, $process);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
