<?php

namespace App\Command;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocket\MessageHandler;
use App\Services\EnvironmentService;
 
class WebSocketServerCommand extends Command
{
    protected static $defaultName = "websocket:start";

    /**
     * @var EnvironmentService $environmentService
     */
    private EnvironmentService $environmentService;

    /**
     * @param EnvironmentService $environmentService
     */
    public function __construct(EnvironmentService $environmentService)
    {
        $this->environmentService = $environmentService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $this->environmentService->getWebSocket('port');

        $output->writeln('Server running on port: ' . $port);
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MessageHandler()
                )
            ),
            $port
        );

        $server->run();

        return Command::SUCCESS;
    }
}