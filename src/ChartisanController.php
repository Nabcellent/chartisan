<?php

namespace Nabcellent\Chartisan;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChartisanController
{
    public function __invoke(Request $request, ...$args): JsonResponse
    {
        return new JsonResponse($args[0]->handler($request)->toObject());
    }
}
