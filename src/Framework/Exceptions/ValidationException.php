<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use RuntimeException;

class ValidationException extends RuntimeException
{
    // Default status code is 422, form field/s are empty
    public function __construct(public array $errors, int $code = 422)
    {
        parent::__construct(code: $code); // using named arguments
    }
}
