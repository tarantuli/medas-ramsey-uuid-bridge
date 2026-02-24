<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge\Exceptions;

use Medas\Core\Exceptions\BaseException;

class InvalidBytesGiven extends BaseException
{
    private \Throwable $previous;

    public function __construct(string $bytes, \Throwable $previous)
    {
        $this->previous = $previous;

        parent::__construct($bytes);
    }

    public function pattern(): string
    {
        return 'Invalid bytes given: %s';
    }

    public function previous(): \Throwable|null
    {
        return $this->previous;
    }
}
