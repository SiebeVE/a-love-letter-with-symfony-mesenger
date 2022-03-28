<?php

namespace App\Handler;

use App\Entity\Letter;
use App\LetterService\LetterService;
use App\Repository\LetterRepository;
use LogicException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

#[AsMessageHandler]
final class SentLetter
{
    public function __construct(
        private LetterRepository $letterRepository,
        private LetterService $letterService,
    ) {
    }

    public function __invoke(\App\Message\SentLetter $message)
    {
        $letter = $this->letterRepository->find($message->letterId);

        if (!$letter instanceof Letter) {
            throw new LogicException('Unable to find letter!');
        }

        if ($letter->getMessage() === 'unrec') {
            throw new UnrecoverableMessageHandlingException('This message won\'t be retried.');
        }

        if (random_int(0, 5) >= 1) {
            throw new LogicException('Random fail!');
        }

        $this->letterService->send($letter);
    }
}
