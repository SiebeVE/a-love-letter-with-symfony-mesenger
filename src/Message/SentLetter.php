<?php

namespace App\Message;

final class SentLetter
{
    public function __construct(
      public int $letterId
    ) {
    }
}
