<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController};

function registerRoutes(App $app)
{
    $app->get("/", [HomeController::class, "home"]); // adds home page to router
    $app->get("/about", [AboutController::class, "about"]);
}
