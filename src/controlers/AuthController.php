<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class AuthController extends AppController {

    public function login() {
        $userRepository = new UserRepository();
        
        if($this->getRequestMethod() !== 'POST') {
            $this->render("login");
            return;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = $userRepository->getUserByEmail($email ?? '');

        if(!$user) {
            $this->render("login", ["error" => "User not found"]);
            return;
        }

        if($user->getEmail() !== $email || !$user->verifyPassword($password)) {
            $this->render("login", ["error" => "Invalid email or password"]);
            return;
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        return header("Location: ${url}/dashboard");
    }
}
