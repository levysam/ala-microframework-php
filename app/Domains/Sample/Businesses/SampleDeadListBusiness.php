<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleDeadListRepository;

class SampleDeadListBusiness extends BaseBusiness
{
    private $sampleDeadListRepository;

    /**
     * constructor
     * @param SampleDeadListRepository $sampleDeadListRepository
     * @return void
     */
    public function __construct(
        SampleDeadListRepository $sampleDeadListRepository
    ) {
        $this->sampleDeadListRepository = $sampleDeadListRepository;
    }

    /**
     * process the request with business rules
     * @param array $fields
     * @param string $order
     * @param string $class
     * @param array|null $filters
     * @param array $query
     * @return array
     */
    public function process(
        array $fields,
        string $order,
        string $class,
        ? array $filters,
        array $query
    ): array {
        $this->setRepositoryTable(
            $this->sampleDeadListRepository
        );

        return $this->sampleDeadListRepository->getList(
            $fields,
            $order,
            $class,
            $filters,
            $query,
            'whereNotNull'
        );
    }
}
