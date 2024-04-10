<?php

declare(strict_types=1);

use FrameWork\TemplateEngine;
use App\Config\Paths;

return [
    TemplateEngine::class => function () {
        return new TemplateEngine(Paths::VIEW);
    }
];
