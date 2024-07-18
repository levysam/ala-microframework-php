<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleDetailRepository;
use App\Exceptions\Custom\DataNotFoundException;

class SampleDetailBusiness extends BaseBusiness
{
    private $sampleDetailRepository;

    /**
     * constructor
     * @param SampleDetailRepository $sampleDetailRepository
     * @return void
     */
    public function __construct(
        SampleDetailRepository $sampleDetailRepository
    ) {
        $this->sampleDetailRepository = $sampleDetailRepository;
    }

    /**
     * process the request with business rules
     * @param string $id
     * @throws DataNotFoundException
     * @return array
     */
    public function process(
        string $id
    ): array {
        $this->setRepositoryTable(
            $this->sampleDetailRepository
        );

        $result = $this->sampleDetailRepository->getById(
            $id
        );

        if (empty($result)) {
            throw new DataNotFoundException;
        }

        return $result;
    }
}
