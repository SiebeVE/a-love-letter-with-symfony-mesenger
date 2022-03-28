<?php

namespace App\Handler;

use App\Entity\Letter;
use App\Repository\LetterRepository;
use App\Service\SendService;
use LogicException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SentLetter
{
    public function __construct(
        private LetterRepository $letterRepository,
        private SendService $sendService,
    ) {
    }

    public function __invoke(\App\Message\SentLetter $message)
    {
        $letter = $this->letterRepository->find($message->letterId);

        if (!$letter instanceof Letter) {
            throw new LogicException('Unable to find letter!');
        }

        $this->sendService->send($letter);
    }
}
