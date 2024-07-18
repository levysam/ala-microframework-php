<?php

namespace App\Domains\Sample\Http\Parameters;

use App\Http\Parameters\BaseParameters;

class SampleParameters extends BaseParameters
{
    /**
     * set allowed fields for this domain
     */
    public $fields = [
        'id',
        'field',
        'created',
        'modified',
        'deleted',
    ];

    /**
     * set allowed orders for this domain
     */
    public $order = [
        'id',
        'created',
        'modified',
        'deleted',
    ];
}
