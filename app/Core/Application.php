<?php

namespace App\Core;

use App\Core\Container\Container;
use App\Core\Container\ContainerException;

/**
 * Class Application
 * @package App\Core
 * @author Cristian Stancu <cristisst@gmail.com>
 */
class Application extends Container
{
    /**
     * @var string
     */
    private string $basePath;

    /**
     * @var Application|null
     */
    private static ?Application $instance = null;


    /**
     * @param $basePath
     * @throws ContainerException
     */
    public function __construct($basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        static::setInstance($this);

        // Initialize the application (e.g., register services)
        $this->initialize();
    }

    /**
     * @param $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
        return $this;
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public static function setInstance(?Application $instance = null): ?Application
    {
        return static::$instance = $instance;
    }

    /**
     * @param null $basePath
     * @return Application
     * @throws ContainerException
     */
    public static function getInstance($basePath = null): Application
    {
        if (self::$instance === null) {
            self::$instance = new self($basePath);
        }

        return self::$instance;
    }

    /**
     * @return void
     * @throws ContainerException
     */
    public function initialize(): void
    {
        $this->loadConfig($this->basePath . '/config/');
    }
}