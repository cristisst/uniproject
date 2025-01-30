<?php
namespace App\Core\Template;
/**
 * Class Template
 * @package App\Core\Template
 * @author Cristian Stancu <cristisst@gmail.com>
 */
class Template
{
    /**
     * $contentTags
     * @var string[]
     */
    private $contentTags = ['{{', '}}'];

    /**
     * $viewAbsolutePath
     * @var mixed
     */
    private $viewAbsolutePath;

    /**
     * $cached_file
     * @var mixed
     */
    private $cached_file;

    /**
     * $cache_enabled
     * @var true
     */
    private $cache_enabled = false;

    /**
     * @var string
     */
    private $cache_path = 'cache/views';

    /**
     * @param $viewAbsolutePath
     * @param $cache_path
     */
    public function __construct($viewAbsolutePath, $cache_path){
        $this->viewAbsolutePath = rtrim($viewAbsolutePath,'/');
        $this->cache_path = rtrim($cache_path,'/');
    }

    /**
     * @param $view
     * @param array $data
     * @return string|false
     */
    public function render($view, array $data = []): string|bool
    {
        //set the relative paths for include other templates in it

        extract($data, EXTR_OVERWRITE);

        if (!file_exists($this->cache_path)) {
            mkdir($this->cache_path, 0744, true);
        }

        $this->cached_file = $this->cache_path."/".str_replace("/", "_", $view);

        $file = $this->compileFile($this->viewAbsolutePath . '/' . $view);

        ob_start();
        require $file;
        return ob_get_clean();
    }

    /**
     * @param $view
     * @return mixed
     */
    public function compileFile($view)
    {
        if(
            !$this->cache_enabled
            || !file_exists($this->cached_file)
            || filemtime($this->cached_file) < filemtime($view)
        ) {
            $value = $this->includeFiles($view);

//            $value = $this->compileCode($value);

            $value = $this->compileEchos($value);

            file_put_contents($this->cached_file, $value);
        }

        return $this->cached_file;
    }

    /**
     * @param $view
     * @return array|string|null
     */
    public function includeFiles($view): array|string|null
    {
        $file = file_get_contents($view);

        //this pattern matches all the lines with @include; the 4th group is the one within the parenthesis
        $pattern = '/\B@(@?include?)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x';

//        return preg_replace_callback($pattern, function($matches) {
        return preg_replace_callback('/@include\s*\(\s*[\'"](.+?)[\'"]\s*\)/', function($matches) {

            //replace the @include with the content of the file to be included
            //calling this method recursively until all the includes are resolved
            return $this->includeFiles($this->viewAbsolutePath.'/'.$matches[1]);
        }, $file);
    }

    /**
     * @param $value
     * @return array|string|null
     */
    public function compileCode($value): array|string|null
    {
        $pattern = '/\B@([ \t]*)(.*)?/x';
        return preg_replace_callback($pattern, function($matches) {
            return "<?php ".$matches[2]." ?>";
        }, $value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function compileEchos($value)
    {
        foreach ($this->getEchoMethods() as $method) {
            $value = $this->$method($value);
        }

        return $value;
    }

    /**
     * @return string[]
     */
    public function getEchoMethods(): array
    {
        return [
            'compileRegularEchos',
            'compileConditionalEchos',
            'compileLoopsEchos',
        ];

    }

    public function compileLoopsEchos($value)
    {
        $value = preg_replace('/@foreach\s*\((.+?)\)/', '<?php foreach ($1): ?>', $value);
        $value = preg_replace('/@endforeach/', '<?php endforeach; ?>', $value);
        return $value;

    }

    public function compileConditionalEchos($value)
    {
        $value = preg_replace('/@if\s*\((.*)\)/', '<?php if ($1): ?>', $value);
        $value = preg_replace('/@elseif\s*\((.*)\)/', '<?php elseif ($1): ?>', $value);
        $value = preg_replace('/@else/', '<?php else: ?>', $value);
        $value = preg_replace('/@endif/', '<?php endif; ?>', $value);
        return $value;
    }
    /**
     * @param $value
     * @return array|string|string[]|null
     */
    public function compileRegularEchos($value)
    {
        $pattern = sprintf('/(@)?%s\s*(.+?)\s*%s(\r?\n)?/s', $this->contentTags[0], $this->contentTags[1]);
        return preg_replace_callback($pattern, function($matches) {
            return "<?php echo {$matches[2]} ?>";
        }, $value);
    }


}