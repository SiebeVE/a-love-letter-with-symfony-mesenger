<?php

namespace App\Middleware;

use App\Message\SentPackage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\AckStamp;

class MessagesLogger implements MiddlewareInterface
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if($message instanceof SentPackage) {
            $this->logger->info('Hurray, sending a package!');
            dump('Hurray, sending a package!');
        }

        dump('Passed the middleware!');

        return $stack->next()->handle($envelope, $stack);
    }
}
