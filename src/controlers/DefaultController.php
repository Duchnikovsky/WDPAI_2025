<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {
        if ($this->isLoggedIn()) {
            header("Location: /dashboard");
            exit;
        }
        $this->render("login");
    }

    public function dashboard()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /index");
            exit;
        }

        $this->render("dashboard");
    }

    public function signup()
    {
        if ($this->isLoggedIn()) {
            header("Location: /dashboard");
            exit;
        }

        $this->render("signup");
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /index");
        exit;
    }

    public function categories()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /index");
            exit;
        }

        require_once __DIR__ . '/../repository/CategoryRepository.php';
        $repo = new CategoryRepository();
        $categories = $repo->getAll();

        $this->render("categories", ["categories" => $categories]);
    }

    public function bestsellers()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /index");
            exit;
        }
        require_once __DIR__ . '/../repository/StatisticsRepository.php';
        $repo = new StatisticsRepository();
        $bestsellers = $repo->getMonthlyBestsellers();

        $this->render("bestsellers", ["bestsellers" => $bestsellers]);
    }

    public function management()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /index");
            exit;
        }

        if(!$this->isAdmin()) {
            header("Location: /dashboard");
            exit;
        }

        require_once __DIR__ . '/../repository/CategoryRepository.php';
        require_once __DIR__ . '/../repository/LibraryRepository.php';

        $categoryRepo = new CategoryRepository();
        $categories = $categoryRepo->getAll();
        $libraryRepo = new LibraryRepository();
        $libraries = $libraryRepo->getAll();

        $this->render("management", ["categories" => $categories, "libraries" => $libraries]);
    }
}
