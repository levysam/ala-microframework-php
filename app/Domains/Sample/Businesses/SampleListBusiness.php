<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleListRepository;

class SampleListBusiness extends BaseBusiness
{
    private $sampleListRepository;

    /**
     * constructor
     * @param SampleListRepository $sampleListRepository
     * @return void
     */
    public function __construct(
        SampleListRepository $sampleListRepository
    ) {
        $this->sampleListRepository = $sampleListRepository;
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
            $this->sampleListRepository
        );

        return $this->sampleListRepository->getList(
            $fields,
            $order,
            $class,
            $filters,
            $query,
            'whereNull'
        );
    }
}
