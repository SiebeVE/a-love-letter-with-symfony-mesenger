<?php

namespace App\Service;

use App\Entity\Letter;
use App\Entity\Package;
use Doctrine\ORM\EntityManagerInterface;

final class SendService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function send(Letter|Package $item): void
    {
        sleep($item instanceof Package ? 60 : 20);
        $item->setSent(true);
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }
}
