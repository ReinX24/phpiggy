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
            $_SESSION["errors"] = $e->errors;
            // Storing the url where the form was submitted
            $referer = $_SERVER["HTTP_REFERER"];
            // Redirect to the same url
            redirectTo($referer);
        }
    }
}
