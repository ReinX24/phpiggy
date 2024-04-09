<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basePath)
    {
    }

    public function render(string $template, array $data = [])
    {
        // Converts keys into variables and their values, skips duplicates.
        // EXTR_SKIP means that if the variable already exists in the function,
        // then do not reassign the value with the extract method.
        extract($data, EXTR_SKIP);
        include "{$this->basePath}/{$template}";
    }
}
