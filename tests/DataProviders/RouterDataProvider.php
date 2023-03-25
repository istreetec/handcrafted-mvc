<?php
declare(strict_types=1);

namespace Tests\DataProviders;

class RouterDataProvider
{
    public function routeNotFoundCases(): array
    {
        return [
            // Array elements inside inner array are the arguments to the test case 
            // which uses this data provider

            // Tip::
            // Each of the below arrays represent different test cases which would
            // result to RouteNotFoundException.
            ["/users", "put"],
            ["/invoices", "post"],
            ["/users", "get"],
            ["/users", "post"],
        ];
    }
}
