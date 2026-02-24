<?php

declare(strict_types=1);

namespace Medas\RamseyUuidBridge\Exceptions;

use Medas\Core\Exceptions\BaseException;

class InvalidStringGiven extends BaseException
{
    private \Throwable $previous;

    public function __construct(string $string, \Throwable $previous)
    {
        $this->previous = $previous;

        parent::__construct($string);
    }

    public function pattern(): string
    {
        return 'Invalid string given: %s';
    }

    public function previous(): \Throwable|null
    {
        return $this->previous;
    }
}
