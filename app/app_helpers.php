<?php

use App\Core\Application;
use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Http\Routing\Request;
use App\Core\Template\Template;
use App\Core\Template\View;

// Helper: Retrieve the singleton application instance
if (!function_exists('app')) {
    /**
     * Retrieve the singleton application instance.
     *
     * @return Application
     * @throws ContainerException
     */
    function app(): Application
    {
        // Retrieve (or initialize) the Application instance.
        return Application::getInstance();
    }
}

// Helper: Retrieve the current HTTP request
if (!function_exists('request')) {
    /**
     * Retrieve the current HTTP request instance.
     *
     * @return Request
     * @throws ContainerException
     * @throws NotFoundException
     */
    function request(): Request
    {
        // Check if the request instance is bound in the application container
        if (!app()->has('request')) {
            // If not, create and bind a new Request instance
            app()->set('request', new Request());
        }

        // Return the request instance
        return app()->get('request');
    }
}

// Helper: Get the View instance for rendering templates
if (!function_exists('view')) {
    /**
     * Retrieve the View instance bound in the application.
     *
     * @return View
     * @throws ContainerException|NotFoundException
     */
    function view(): View
    {
        // Ensure that the View instance is bound in the application container
        if (!app()->has('view')) {
            $templatePath = app()->getBasePath() . '/views'; // Use the application's base path for locating views
            $cachePath = app()->getBasePath() . '/cache/views';
            app()->set('view', new View($templatePath, $cachePath));
        }

        // Return the bound View instance
        return app()->get('view');
    }
}

if (!function_exists('template')) {
    /**
     * Retrieve the View instance bound in the application.
     *
     * @return Template
     * @throws ContainerException
     * @throws NotFoundException
     */
    function template(): Template
    {
        // Ensure that the View instance is bound in the application container
        if (!app()->has('template')) {
            $templatePath = app()->getBasePath() . '/views'; // Use the application's base path for locating views
            $cachePath = app()->getBasePath() . '/cache/views';
            app()->set('view', new Template($templatePath, $cachePath));
        }

        // Return the bound View instance
        return app()->get('view');
    }
}

if (!function_exists('uuid')) {
    /**
     * Generate a unique identifier (UUID).
     *
     * @return string A 32-character hexadecimal string representing a UUID.
     * @throws Exception If it was not possible to gather sufficient entropy.
     */
    function uuid(): string
    {
        return bin2hex(random_bytes(16));
    }
}