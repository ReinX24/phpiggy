<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidationException $e) {
            $oldFormData = $_POST;

            $excludedFields = ["password", "confirmPassword"];
            // array_diff_key joins two arrays and removes elements with the 
            // same key
            // array_flip converts the array values into keys
            $formattedFormData = array_diff_key(
                $oldFormData,
                array_flip($excludedFields)
            );

            $_SESSION["errors"] = $e->errors;
            $_SESSION["oldFormData"] = $formattedFormData;

            // Storing the url where the form was submitted
            $referer = $_SERVER["HTTP_REFERER"];
            // Redirect to the same url
            redirectTo($referer);
        }
    }
}
