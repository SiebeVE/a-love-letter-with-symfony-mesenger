<?php

namespace App\LetterService;

use App\Entity\Letter;
use Doctrine\ORM\EntityManagerInterface;

final class LetterService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function send(Letter $letter): void
    {
        sleep(20);
        $letter->setSent(true);
        $this->entityManager->persist($letter);
        $this->entityManager->flush();
    }
}
