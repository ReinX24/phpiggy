<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\SessionException;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        // Checks if a session has already started
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session already active.");
        }

        // Checks if data has already been sent to the browser, which means 
        // that we can't start a session
        if (headers_sent($filename, $line)) {
            throw new SessionException(
                "Headers already sent. Consider enabling output buffering.
                Data outputted from {$filename} - Line: {$line}"
            );
        }

        // Because output buffering is enabled, we can start sessions even if
        // content is loaded before the session has started. This is enabled
        // by default
        session_start();

        $next();

        session_write_close();
    }
}
