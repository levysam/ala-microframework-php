<?php

namespace App\Domains\Sample\Businesses;

use App\Domains\Sample\Repositories\SampleListRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleListBusinessTest extends TestCase
{
    /**
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::__construct
     */
    public function testCreateBusiness()
    {
        $sampleListRepositorySpy = Mockery::spy(
            SampleListRepository::class
        );

        $sampleListBusiness = new SampleListBusiness(
            $sampleListRepositorySpy
        );

        $this->assertInstanceOf(
            SampleListBusiness::class,
            $sampleListBusiness
        );
    }

    /**
     * @covers \App\Domains\Sample\Businesses\SampleListBusiness::process
     */
    public function testProcess()
    {
        $data = [
            'id' => '01E4E7RTJ3C11B6Z0H0QTJCW04',
            'field' => 'teste',
        ];

        $sampleListRepositoryMock = Mockery::mock(
            SampleListRepository::class
        )->shouldReceive('getList')
            ->withAnyArgs()
            ->andReturn($data)
            ->getMock();

        $sampleListBusiness = Mockery::mock(
            SampleListBusiness::class,
            [
                $sampleListRepositoryMock,
            ]
        )->makePartial();

        $sampleListBusiness->shouldReceive('setRepositoryTable')
            ->with($sampleListRepositoryMock)
            ->once()
            ->andReturn(true);

        $process = $sampleListBusiness->process(
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
