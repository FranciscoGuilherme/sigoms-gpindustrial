<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Interfaces\SoapClientInterface;
use App\Interfaces\EnvironmentInterface;
use App\Helpers\MessagesHelper\ProcessMessagesHelper as Helper;

class ProcessController extends AbstractController
{
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
     * @Route("/gpi/process", name="process")
     * 
     * @throws \Exception
     * 
     * @return JsonResponse
     */
    public function action(Request $request): JsonResponse
    {
        $token = $request->headers->get('authorization');

        try {
            $this->soapClientInterface->connect(
                $this->environmentInterface->getRoute('process'), $token
            );
        }
        catch (\Exception $e) {
            return new JsonResponse([
                'message' => Helper::PROCESS_ERROR_CONNECTION_MESSAGE,
                'details' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse([
            $this->soapClientInterface->request(
                $this->environmentInterface->getResource('process')
            )
        ], Response::HTTP_OK);
    }
}