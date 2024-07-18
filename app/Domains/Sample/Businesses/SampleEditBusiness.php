<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleEditRepository;
use App\Exceptions\Custom\DataNotFoundException;

class SampleEditBusiness extends BaseBusiness
{
    private $sampleEditRepository;

    /**
     * constructor
     * @param SampleEditRepository $sampleEditRepository
     * @return void
     */
    public function __construct(
        SampleEditRepository $sampleEditRepository
    ) {
        $this->sampleEditRepository = $sampleEditRepository;
    }

    /**
     * process the request with business rules
     * @param array $data
     * @param string $id
     * @throws DataNotFoundException
     * @return array
     */
    public function process(
        array $data,
        string $id
    ): array {
        $this->setRepositoryTable(
            $this->sampleEditRepository
        );

        $exists = $this->sampleEditRepository->getById(
            $id
        );

        if (empty($exists)) {
            throw new DataNotFoundException;
        }

        $this->sampleEditRepository->update(
            $data,
            $id
        );

        return $this->sampleEditRepository->getById(
            $id
        );
    }
}
