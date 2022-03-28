<?php

namespace App\Handler;

use App\Entity\Package;
use App\Repository\PackageRepository;
use App\Service\SendService;
use LogicException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SentPackage
{
    public function __construct(
        private PackageRepository $packageRepository,
        private SendService $sendService,
    ) {
    }

    public function __invoke(\App\Message\SentPackage $message)
    {
        $package = $this->packageRepository->find($message->packageId);

        if (!$package instanceof Package) {
            throw new LogicException('Unable to find package!');
        }

        $this->sendService->send($package);
    }
}
