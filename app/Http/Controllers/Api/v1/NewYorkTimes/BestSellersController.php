<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1\NewYorkTimes;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\NewYorkTimes\BestSellersRequest;
use App\Services\NewYorkTimes\BestSellersService;
use Illuminate\Http\JsonResponse;

class BestSellersController extends ApiController
{
    /**
     * Provision a new web server.
     *
     */
    public function __invoke(BestSellersRequest $request, BestSellersService $bestSellersService): JsonResponse
    {
        $validationResponse = $this->checkRequestValidation($request);
        if (null !== $validationResponse) {
            return $validationResponse;
        }

        $searchResult = $bestSellersService->search($request->all());

        return $this->responseSuccess($searchResult);
    }
}
