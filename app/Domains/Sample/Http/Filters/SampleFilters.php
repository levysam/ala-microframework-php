<?php

namespace App\Domains\Sample\Http\Filters;

use App\Http\Filters\BaseFilters;
use App\Constants\FiltersTypesConstants;

class SampleFilters extends BaseFilters
{
    /**
     * set filter rules for this domain
     */
    public $filter = [
        'field' => [
            'validate' => 'string|min:3',
            'permissions' => [
                FiltersTypesConstants::FILTER_EQUAL,
                FiltersTypesConstants::FILTER_NOT_EQUAL,
                FiltersTypesConstants::FILTER_LIKE,
            ],
        ],
        'created' => [
            'validate' => 'date',
            'permissions' => [
                FiltersTypesConstants::FILTER_LESS_THAN,
                FiltersTypesConstants::FILTER_GREATER_THAN,
                FiltersTypesConstants::FILTER_GREATER_THAN_OR_EQUAL,
                FiltersTypesConstants::FILTER_LESS_THAN_OR_EQUAL,
            ],
        ],
        'modified' => [
            'validate' => 'date',
            'permissions' => [
                FiltersTypesConstants::FILTER_LESS_THAN,
                FiltersTypesConstants::FILTER_GREATER_THAN,
                FiltersTypesConstants::FILTER_GREATER_THAN_OR_EQUAL,
                FiltersTypesConstants::FILTER_LESS_THAN_OR_EQUAL,
            ],
        ],
    ];
}
