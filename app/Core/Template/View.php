<?php

namespace App\Core\Template;

use Exception;

class View
{
    protected string $viewPath;
    protected string $cachePath;

    public function __construct(string $viewPath, string $cachePath)
    {
        $this->viewPath = rtrim($viewPath, '/');
        $this->cachePath = rtrim($cachePath, '/');
    }

    /**
     * Render a template with data.
     *
     * @param string $template The template name.
     * @param array $data The data to pass to the template.
     * @return string
     */
    public function render(string $template, array $data = []): string
    {
        $compiledPath = $this->getCompiledPath($template);

        // Recompile if the template file has been updated.
        if (!file_exists($compiledPath) || filemtime($this->getTemplatePath($template)) > filemtime($compiledPath)) {
            $this->compile($template);
        }

        // Extract variables and include the compiled template.
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include $compiledPath;
        return ob_get_clean();
    }

    /**
     * Compile a template to PHP.
     *
     * @param string $template The template name.
     */
    protected function compile(string $template): void
    {
        $templatePath = $this->getTemplatePath($template);
        $compiledPath = $this->getCompiledPath($template);

        $contents = file_get_contents($templatePath);
        $compiledContents = $this->compileString($contents);

        // Ensure the cache directory exists.
        if (!is_dir(dirname($compiledPath))) {
            mkdir(dirname($compiledPath), 0755, true);
        }

        file_put_contents($compiledPath, $compiledContents);
    }

    /**
     * Compile the template string into PHP code.
     *
     * @param string $value The template string.
     * @return string
     */
    protected function compileString(string $value): string
    {
        // Compile variables (e.g., {{ $name }}).
        $value = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?= htmlspecialchars($1) ?>', $value);

        // Compile @if, @elseif, @else, @endif.
        $value = preg_replace('/@if\s*\((.+?)\)/', '<?php if ($1): ?>', $value);
        $value = preg_replace('/@elseif\s*\((.+?)\)/', '<?php elseif ($1): ?>', $value);
        $value = preg_replace('/@else/', '<?php else: ?>', $value);
        $value = preg_replace('/@endif/', '<?php endif; ?>', $value);

        // Compile @foreach, @endforeach.
        $value = preg_replace('/@foreach\s*\((.+?)\)/', '<?php foreach ($1): ?>', $value);
        $value = preg_replace('/@endforeach/', '<?php endforeach; ?>', $value);

        // Compile @include.
        $value = preg_replace_callback('/@include\s*\(\s*[\'"](.+?)[\'"]\s*\)/', function ($matches) {
            $includeTemplate = $matches[1];
            return '<?php include $this->getCompiledPath("' . $includeTemplate . '"); ?>';
        }, $value);

        return $value;
    }

    /**
     * Get the full path to a template file.
     *
     * @param string $template The template name.
     * @return string
     */
    protected function getTemplatePath(string $template): string
    {
        return $this->viewPath . '/' . str_replace('.', '/', $template) . '.tpl';
    }

    /**
     * Get the full path to a compiled template file.
     *
     * @param string $template The template name.
     * @return string
     */
    protected function getCompiledPath(string $template): string
    {
        return $this->cachePath . '/' . str_replace('.', '/', $template) . '.php';
    }
}