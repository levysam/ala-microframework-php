<?php

namespace App\Domains\Sample\Businesses;

use App\Businesses\BaseBusiness;
use App\Domains\Sample\Repositories\SampleDeleteRepository;
use App\Exceptions\Custom\DataNotFoundException;

class SampleDeleteBusiness extends BaseBusiness
{
    private $sampleDeleteRepository;

    /**
     * constructor
     * @param SampleDeleteRepository $sampleDeleteRepository
     * @return void
     */
    public function __construct(
        SampleDeleteRepository $sampleDeleteRepository
    ) {
        $this->sampleDeleteRepository = $sampleDeleteRepository;
    }

    /**
     * process the request with business rules
     * @param string $id
     * @throws DataNotFoundException
     * @return bool
     */
    public function process(
        string $id
    ) : bool {
        $this->setRepositoryTable(
            $this->sampleDeleteRepository
        );

        $exists = $this->sampleDeleteRepository->getById(
            $id
        );

        if (empty($exists)) {
            throw new DataNotFoundException;
        }

        $this->sampleDeleteRepository->delete(
            $id
        );

        return true;
    }
}
