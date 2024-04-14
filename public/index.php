<?php

// TODO: continue at 13. Master Project Form Validation

include __DIR__ . "/../src/App/functions.php";

$app = include __DIR__ . "/../src/App/bootstrap.php";

$app->run();

// 12-18 code.
/*
declare(strict_types=1);

$functions = [
    function ($next) {
        echo "A <br>";
        $next();
        echo "After Main Content";
    },
    function ($next) {
        echo "B <br>";
        $next();
    },
    function ($next) {
        echo "C <br>";
        $next();
    }
];

$a = function () {
    echo "Main content <br>";
};

foreach ($functions as $function) {
    $a = fn () => $function($a);
}

$a();
*/