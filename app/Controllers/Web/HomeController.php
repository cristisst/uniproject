<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Exception;

class HomeController extends BaseController
{
    /**
     * @throws Exception
     */
    public function index(): bool|string
    {
        $this->data['heading'] = 'Welcome to Our Shopping Cart!';
        $this->data['title'] = 'Home';
        // Return the rendered template content
        return template()->render('home.tpl.php', $this->data);
    }

    public function about(): void
    {
        echo 'This is the about page.';
    }
}