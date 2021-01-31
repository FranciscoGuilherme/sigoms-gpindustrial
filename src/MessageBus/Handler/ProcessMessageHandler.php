<?php

namespace App\MessageBus\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Interfaces\EnvironmentInterface;
use App\MessageBus\Message\ProcessMessage;

/**
 * @package App\MessageBus\Handler
 */
class ProcessMessageHandler implements MessageHandlerInterface
{
    /**
     * @var EnvironmentInterface $environmentInterface
     */
    private EnvironmentInterface $environmentInterface;

    /**
     * @param EnvironmentInterface $environmentInterface
     */
    public function __construct(EnvironmentInterface $environmentInterface)
    {
        $this->environmentInterface = $environmentInterface;
    }

    /**
     * @param ProcessMessage $processMessage
     */
    public function __invoke(ProcessMessage $processMessage)
    {
        $processMessage->notify();
    }
}