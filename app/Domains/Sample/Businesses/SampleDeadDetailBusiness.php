<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleDeadDetailRepository;
use App\Exceptions\Custom\DataNotFoundException;

class SampleDeadDetailBusiness extends BaseBusiness
{
    private $sampleDeadDetailRepository;

    /**
     * constructor
     * @param SampleDeadDetailRepository $sampleDeadDetailRepository
     * @return void
     */
    public function __construct(
        SampleDeadDetailRepository $sampleDeadDetailRepository
    ) {
        $this->sampleDeadDetailRepository = $sampleDeadDetailRepository;
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
            $this->sampleDeadDetailRepository
        );

        $result = $this->sampleDeadDetailRepository->getDeadById(
            $id
        );

        if (empty($result)) {
            throw new DataNotFoundException;
        }

        return $result;
    }
}
