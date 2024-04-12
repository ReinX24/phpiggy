<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;

return [
    // Returns a new instance of the TemplateEngine class
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW)
];
