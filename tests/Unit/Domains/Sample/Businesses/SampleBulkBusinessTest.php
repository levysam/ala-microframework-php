<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleBulkRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleBulkBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleBulkBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleBulkRepositorySpy = Mockery::spy(
            SampleBulkRepository::class
        );

        $sampleBulkBusiness = new SampleBulkBusiness(
            $sampleBulkRepositorySpy
        );

        $this->assertInstanceOf(
            SampleBulkBusiness::class,
            $sampleBulkBusiness
        );
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleBulkBusiness::process
     */
    public function testProcess()
    {
        $sampleBulkRepositoryMock = Mockery::mock(
            SampleBulkRepository::class
        )->shouldReceive('getBulk')
            ->with(
                [
                    '01E4E622FPAKTD2T7YNNWPPYPN',
                    '01E4E6293KGGR7P6EYWZY79A27',
                    '01E4E62JN67PXCSAMW7Z1D4XYP',
                    '01E4E62TR8CZ64C7JTQXYEK3BY',
                ],
                ['id', 'field'],
                '',
                '',
                []
            )
            ->andReturn([])
            ->getMock();

        $sampleBulkBusiness = Mockery::mock(
            SampleBulkBusiness::class,
            [
                $sampleBulkRepositoryMock,
            ]
        )->makePartial();

        $sampleBulkBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleBulkRepositoryMock)
            ->once()
            ->andReturn(true);

        $business = $sampleBulkBusiness->process(
            [
                '01E4E622FPAKTD2T7YNNWPPYPN',
                '01E4E6293KGGR7P6EYWZY79A27',
                '01E4E62JN67PXCSAMW7Z1D4XYP',
                '01E4E62TR8CZ64C7JTQXYEK3BY',
            ],
            ['id', 'field'],
            '',
            '',
            []
        );

        $this->assertEquals(
            [],
            $business
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
