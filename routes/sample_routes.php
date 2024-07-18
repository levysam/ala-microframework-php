<?php

$patterns = [
    'id' => '[0-9A-Z]{26}',
];

$router->delete(
    "/sample/delete/{id:{$patterns['id']}}",
    [
        'uses' => 'SampleDeleteController@process',
    ]
);

$router->get(
    '/sample/dead_list',
    [
        'uses' => 'SampleDeadListController@process',
        'validator' => 'App\Domains\Sample\Http\Validators\SampleDeadListValidator',
        'parameters' => 'App\Domains\Sample\Http\Parameters\SampleParameters',
        'filters' => 'App\Domains\Sample\Http\Filters\SampleFilters',
    ]
);

$router->get(
    '/sample/list',
    [
        'uses' => 'SampleListController@process',
        'validator' => 'App\Domains\Sample\Http\Validators\SampleListValidator',
        'parameters' => 'App\Domains\Sample\Http\Parameters\SampleParameters',
        'filters' => 'App\Domains\Sample\Http\Filters\SampleFilters',
    ]
);

$router->get(
    "/sample/dead_detail/{id:{$patterns['id']}}",
    [
        'uses' => 'SampleDeadDetailController@process',
    ]
);

$router->get(
    "/sample/detail/{id:{$patterns['id']}}",
    [
        'uses' => 'SampleDetailController@process',
    ]
);

$router->patch(
    "/sample/edit/{id:{$patterns['id']}}",
    [
        'uses' => 'SampleEditController@process',
        'validator' => 'App\Domains\Sample\Http\Validators\SampleEditValidator',
    ]
);

$router->post(
    '/sample/add',
    [
        'uses' => 'SampleAddController@process',
        'validator' => 'App\Domains\Sample\Http\Validators\SampleAddValidator',
    ]
);

$router->post(
    '/sample/bulk',
    [
        'uses' => 'SampleBulkController@process',
        'validator' => 'App\Domains\Sample\Http\Validators\SampleBulkValidator',
        'parameters' => 'App\Domains\Sample\Http\Parameters\SampleParameters',
    ]
);
