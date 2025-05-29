<?php

class AppController
{
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function getRequestMethod()
    {
        return $this->request;
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = "public/views/" . $template . ".php";
        $output = "404 Not Found";

        if (file_exists($templatePath)) {
            extract($variables);

            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }

        print $output;
    }

    protected function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }

    protected function isAdmin()
    {
        return $this->isLoggedIn() && $_SESSION['user']['role'] === 'ADMIN';
    }
}
