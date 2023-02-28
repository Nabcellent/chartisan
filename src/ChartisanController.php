<?php

namespace Nabcellent\Chartisan;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChartisanController
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, ...$args): JsonResponse
    {
        return new JsonResponse($args[0]->handler($request)->toObject());
    }
}
