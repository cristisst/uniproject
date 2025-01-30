<?php

namespace App\Core\Http\Routing;

/**
 * Class Request
 * @package App\Core\Http\Routing
 * @author Cristian Stancu <cristisst@gmail.com>
 */
class Request
{
    /**
     * @var string|mixed
     */
    private string $method;
    /**
     * @var string|false
     */
    private string|bool $uri;
    /**
     * @var array
     */
    private array $queryParams;
    /**
     * @var array
     */
    private array $postData;
    /**
     * @var array
     */
    private array $server;

    /**
     *
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = strtok($_SERVER['REQUEST_URI'], '?'); // Removes query string from URI
        $this->queryParams = $_GET ?? [];
        $this->postData = $this->getAllDataPosted();
        $this->server = $_SERVER;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtoupper($this->method);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return '/' . trim($this->uri, '/');
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @return array
     */
    public function getPostData(): array
    {
        return $this->postData;
    }

    /**
     * @param string $key
     * @return string|array
     */
    public function getServer(string $key): string|array
    {
        return $key ? $this->server[$key] : $this->server;
    }

    protected function getAllDataPosted(): array
    {
        $content = [];
        $getData = file_get_contents('php://input');
        if (is_string($getData) && !empty($getData) && $this->json($getData)) {
            $content = json_decode($getData, true);
        }
        return array_merge($_POST, $content);
    }

    protected function json(string $getData): bool
    {
        json_decode($getData);
        return json_last_error() === JSON_ERROR_NONE;
    }
}