<?php

namespace App\MessageBus\Message;

use Amp\Loop;
use Amp\Delayed;
use Amp\Websocket;
use Amp\Websocket\Client;

/**
 * @package App\MessageBus\Message
 */
final class ProcessMessage
{
    /**
     * @var string $name
     */
    private string $name;

    /**
     * @var int $step
     */
    private int $step;

    /**
     * @param string $name
     * @param int $step
     */
    public function __construct(string $name, int $step)
    {
        $this->name = $name;
        $this->step = $step;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStep(): int
    {
        return $this->step;
    }

    public function notify(): void
    {
        Loop::run(function () {
            $connection = yield Client\connect($_ENV['WEBSOCKET_LISTEN_URL']);
            $connection->send($this->getMessage());
            $connection->close();
        });
    }

    /**
     * @return string
     */
    private function getMessage(): string
    {
        return sprintf('%s', $this->name);
    }
}