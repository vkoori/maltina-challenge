<?php

namespace App\Service\Responses\Constraint;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

interface Success
{
    public function ok(array|string $message = null, array|JsonResource|Collection $data = []): JsonResponse;
    public function created(array|string $message = null, array|JsonResource|Collection $data = []): JsonResponse;
}
