<?php

namespace App\Domains\Sample\Http\Validators;

use App\Constants\PatternsConstants;
use App\Http\Validators\BaseValidator;

class SampleDeadListValidator extends BaseValidator
{
    /**
     * get rules for this request
     * @return array
     */
    public function getRules() : array
    {
        return [
            'class' => 'string|in:"asc","desc"',
            'fields' => 'string',
            'order' => 'string',
            'page' => 'integer|min:1',
            'filter_field' => [
                'string',
                'regex:'.PatternsConstants::FILTER,
            ],
            'limit' => 'integer|min:1|max:25',
        ];
    }
}
