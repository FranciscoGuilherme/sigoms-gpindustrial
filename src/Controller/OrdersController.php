<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Interfaces\SoapClientInterface;
use App\Interfaces\EnvironmentInterface;
use App\Helpers\MessagesHelper\OrdersMessagesHelper as Helper;

class OrdersController extends AbstractController
{
    /**
     * @var array $environment
     */
    private array $environment;

    /**
     * @var SoapClientInterface $soapClientInterface
     */
    private SoapClientInterface $soapClientInterface;

    /**
     * @var EnvironmentInterface $environmentInterface
     */
    private EnvironmentInterface $environmentInterface;

    /**
     * @param SoapClientInterface $soapClientInterface
     * @param EnvironmentInterface $environmentInterface
     */
    public function __construct(
        SoapClientInterface $soapClientInterface,
        EnvironmentInterface $environmentInterface
    ) {
        $this->soapClientInterface = $soapClientInterface;
        $this->environmentInterface = $environmentInterface;
    }

    /**
     * @Route("/gpi/orders", name="orders")
     * 
     * @throws \Exception
     * 
     * @return JsonResponse
     */
    public function action(): JsonResponse
    {
        try {
            $this->soapClientInterface->connect($this->environmentInterface->getRoute('orders'));
        }
        catch (\Exception $e) {
            return new JsonResponse([
                'message' => Helper::ORDERS_ERROR_CONNECTION_MESSAGE,
                'details' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            $this->soapClientInterface->request(
                $this->environmentInterface->getResource('orders'),
                [
                    'name' => 'Scott'
                ]
            )
        ], Response::HTTP_OK);
    }
}