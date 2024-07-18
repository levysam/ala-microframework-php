<?php

namespace App\Domains\Sample\Http\Validators;

use App\Constants\PatternsConstants;
use App\Http\Validators\BaseValidator;

class SampleBulkValidator extends BaseValidator
{
    /**
     * get rules for this request
     * @return array
     */
    public function getRules(): array
    {
        return [
            'ids' => 'required|array',
            'ids.*' => [
                'required',
                'string',
                'regex:'.PatternsConstants::ULID,
            ],
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:25',
        ];
    }
}
