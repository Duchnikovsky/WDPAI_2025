<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';

class CategoryController extends AppController
{
    public function addCategory()
    {
        if (!$this->isLoggedIn() || !$this->isAdmin() || $this->getRequestMethod() !== 'POST') {
            header("Location: /dashboard");
            exit;
        }

        $name = $_POST['name'] ?? '';
        $icon = $_POST['icon'] ?? '';

        if (!$name || !$icon) {
            $this->render('dashboard', ['addError' => 'Invalid input']);
            return;
        }

        $repo = new CategoryRepository();

        $category = $repo->findByName($name);
        if (!$category) {
            $repo->addCategory($name, $icon);
        }

        header("Location: /categories");
        exit;
    }
}
