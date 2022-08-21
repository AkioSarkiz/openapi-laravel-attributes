<?php

declare(strict_types=1);

namespace AkioSarkiz\Openapi\Tests\TestApp\Http\Controllers;

use AkioSarkiz\Openapi\Attributes\Route;
use Illuminate\Http\JsonResponse;

class UserController
{
    #[Route]
    public function index(): JsonResponse
    {
        return response()->json();
    }

    #[Route]
    public function store(): JsonResponse
    {
        return response()->json();
    }

    #[Route]
    public function update(): JsonResponse
    {
        return response()->json();
    }

    #[Route]
    public function destroy(): JsonResponse
    {
        return response()->json();
    }
}
