<?php

namespace App\Message;

final class SentPackage
{
    public function __construct(
      public int $packageId
    ) {
    }
}
