<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private $rules = [];

    public function add(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $formData, array $fields)
    {
        $errors = [];

        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {
                $ruleParams = [];

                // Checks if the current rule is a parameter
                if (str_contains($rule, ":")) {
                    [$rule, $currentRuleParam] = explode(":", $rule);
                    $ruleParams = explode(",", $currentRuleParam);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $fieldName, $ruleParams)) {
                    continue; // go to the next field in the array
                }

                // Validation fails
                // Storing fieldName and error messages within another array
                $errors[$fieldName][] = $ruleValidator->getMessage(
                    $formData,
                    $fieldName,
                    $ruleParams
                );
            }
        }

        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }
}
