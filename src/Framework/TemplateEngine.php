<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    private array $globalTemplateData = [];

    public function __construct(private string $basePath)
    {
    }

    public function render(string $template, array $data = [])
    {
        // Converts keys into variables and their values, skips duplicates.
        // EXTR_SKIP means that if the variable already exists in the function,
        // then do not reassign the value with the extract method.
        extract($data, EXTR_SKIP);
        extract($this->globalTemplateData, EXTR_SKIP);

        // Starts output buffering, makes sure that all the content is loaded 
        // before the content is loaded to the page.
        ob_start();

        include $this->resolve($template);
        // include "{$this->basePath}/{$template}";

        $output = ob_get_contents();

        ob_end_clean();

        return $output; // returns the output buffer contents
    }

    public function resolve(string $path)
    {
        return "{$this->basePath}/{$path}";
    }

    public function addGlobal(string $key, mixed $value)
    {
        $this->globalTemplateData[$key] = $value;
    }
}
