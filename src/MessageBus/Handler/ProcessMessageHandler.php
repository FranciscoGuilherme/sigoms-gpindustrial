<?php

namespace App\MessageBus\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\MessageBus\Message\ProcessMessage;

/**
 * @package App\MessageBus\Handler
 */
class ProcessMessageHandler implements MessageHandlerInterface
{
    /**
     * @param ProcessMessage $processMessage
     */
    public function __invoke(ProcessMessage $processMessage)
    {
        $name = $processMessage->getName();
        $step = $processMessage->getStep();

        echo 'Name: ' . $name . ' e step: ' . $step;
    }
}