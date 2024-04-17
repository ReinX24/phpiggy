<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class MinRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        // If the developer forgot to put a parameter
        if (empty($params[0])) {
            throw new InvalidArgumentException("Minimum length not specified.");
        }

        $length = (int) $params[0];
        // Checking if the data from the field is greater than the length
        return $data[$field] >= $length;
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Must be at least {$params[0]}.";
    }
}
