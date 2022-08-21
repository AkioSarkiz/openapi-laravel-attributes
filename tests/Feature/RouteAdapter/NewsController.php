<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\Feature\RouteAdapter;

use AkioSarkiz\Openapi\Attributes\Route;

class NewsController
{
    #[Route]
    private function index()
    {
        //
    }
}
