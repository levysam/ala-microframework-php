<?php

namespace App\Domains\Sample\Http\Validators;

use App\Http\Validators\BaseValidator;

class SampleAddValidator extends BaseValidator
{
    /**
     * get rules for this request
     * @return array
     */
    public function getRules(): array
    {
        return [
            'field' => 'required|string|max:255',
        ];
    }
}
