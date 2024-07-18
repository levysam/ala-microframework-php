<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleBulkRepository;

class SampleBulkBusiness extends BaseBusiness
{
    private $sampleBulkRepository;

    /**
     * constructor
     * @param SampleBulkRepository $sampleBulkRepository
     * @return void
     */
    public function __construct(
        SampleBulkRepository $sampleBulkRepository
    ) {
        $this->sampleBulkRepository = $sampleBulkRepository;
    }

    /**
     * process the request with business rules
     * @param array $ids
     * @param array $fields
     * @param string $order
     * @param string $class
     * @param array $query
     * @return array
     */
    public function process(
        array $ids,
        array $fields,
        string $order,
        string $class,
        array $query
    ): array {
        $this->setRepositoryTable(
            $this->sampleBulkRepository
        );

        return $this->sampleBulkRepository->getBulk(
            $ids,
            $fields,
            $order,
            $class,
            $query
        );
    }
}
