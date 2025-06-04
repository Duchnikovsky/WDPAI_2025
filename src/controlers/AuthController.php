<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class AuthController extends AppController
{

    public function login()
    {
        $userRepository = new UserRepository();

        if ($this->getRequestMethod() !== 'POST') {
            $this->render("login");
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $userRepository->getUserByEmail($email ?? '');

        if (!$user) {
            $this->render("login", ["error" => "User not found"]);
            return;
        }

        if ($user->getEmail() !== $email || !$user->verifyPassword($password)) {
            $this->render("login", ["error" => "Invalid email or password"]);
            return;
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        $_SESSION['user'] = [
            'email' => $user->getEmail(),
            'role' => $user->getRole()
        ];
        header("Location: $url/dashboard");
        exit;
    }

    public function register()
    {
        $userRepository = new UserRepository();

        if ($this->getRequestMethod() !== 'POST') {
            $this->render("signup");
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $accessCode = $_POST['accescode'] ?? '';

        if (empty($email) || empty($password) || empty($accessCode)) {
            $this->render("signup", ["error" => "All fields are required"]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render("signup", ["error" => "Invalid email format"]);
            return;
        }

        if (strlen($password) < 6) {
            $this->render("signup", ["error" => "Password must be at least 6 characters long"]);
            return;
        }

        if ($userRepository->getUserByEmail($email)) {
            $this->render("signup", ["error" => "Email already registered"]);
            return;
        }

        if (!$userRepository->isAccessCodeValid($accessCode)) {
            $this->render("signup", ["error" => "Invalid access code"]);
            return;
        }

        $user = new User($email, $password);
        $userRepository->saveUser($user);
        $userRepository->consumeAccessCode($accessCode);

        $this->render("login", ["success" => "Registration successful! You can now log in."]);
    }

    public function generateCodes()
    {
        if (!$this->isLoggedIn() || !$this->isAdmin() || $this->getRequestMethod() !== 'POST') {
            header("Location: /dashboard");
            exit;
        }

        $quantity = (int)($_POST['quantity'] ?? 0);

        if ($quantity < 1 || $quantity > 100) {
            $this->render('management', ['codeError' => 'You must generate between 1 and 100 codes.']);
            return;
        }

        require_once __DIR__ . '/../repository/UserRepository.php';
        $repo = new UserRepository();
        $codes = [];

        for ($i = 0; $i < $quantity; $i++) {
            $code = $repo->generateUniqueCode();
            $repo->saveAccessCode($code);
            $codes[] = $code;
        }

        $this->render('management', ['generatedCodes' => $codes]);
    }
}
