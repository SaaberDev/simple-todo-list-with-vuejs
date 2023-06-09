<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class SimpleFormatter
{
    public function __invoke($logger): void
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(
                new LineFormatter('[%datetime%]: %message% - %context%' . PHP_EOL, 'F j, Y, g:i a', true)
            );
        }
    }
}
