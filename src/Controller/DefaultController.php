<?php

namespace App\Controller;

use App\Dto\Request\ProductDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/product", methods={"POST"})
     * @param ProductDto $request
     * @return JsonResponse
     */
    public function createPayment(ProductDto $request): JsonResponse
    {
        return new JsonResponse(
            [
                'uuid' => $request->getUuid(),
                'label' => $request->getLabel(),
                'description' => $request->getDescription(),
                'price' => $request->getPrice(),
                'customValue1' => $request->getCustomValue1(),
                'customValue2' => $request->getCustomValue2(),
            ]
        );
    }
}
