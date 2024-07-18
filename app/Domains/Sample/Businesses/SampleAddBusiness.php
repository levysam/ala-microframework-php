<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleAddRepository;

class SampleAddBusiness extends BaseBusiness
{
    private $sampleAddRepository;

    /**
     * constructor
     * @param SampleAddRepository $sampleAddRepository
     * @return void
     */
    public function __construct(
        SampleAddRepository $sampleAddRepository
    ) {
        $this->sampleAddRepository = $sampleAddRepository;
    }

    /**
     * process the request with business rules
     * @param array $data
     * @return array
     */
    public function process(
        array $data
    ): array {
        $this->setRepositoryTable(
            $this->sampleAddRepository
        );

        $id = $this->sampleAddRepository->insert(
            $data
        );

        return $this->sampleAddRepository->getById(
            $id
        );
    }
}
