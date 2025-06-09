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

        if (!$this->isAdmin()) {
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

    public function book()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /index");
            exit;
        }

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->render("book", ["error" => "Book not found"]);
            return;
        }

        $bookId = (int) $_GET['id'];

        require_once __DIR__ . '/../repository/BookRepository.php';
        require_once __DIR__ . '/../repository/LibraryRepository.php';

        $bookRepo = new BookRepository();
        $libraryRepo = new LibraryRepository();

        $book = $bookRepo->getBookById($bookId);
        $availability = $bookRepo->getBookAvailability($bookId);
        $libraries = $libraryRepo->getAll();

        if (!$book) {
            $this->render("book", ["error" => "Book not found"]);
            return;
        }

        $this->render("book", [
            "book" => $book,
            "availability" => $availability,
            "libraries" => $libraries
        ]);
    }

    public function profile()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /index");
            exit;
        }

        require_once __DIR__ . '/../repository/ReservationRepository.php';
        require_once __DIR__ . '/../repository/UserRepository.php';

        $userRepository = new UserRepository();
        $reservationRepository = new ReservationRepository();

        $email = $_SESSION['user']['email'];
        $user = $userRepository->getUserByEmail($email);
        $reservations = $reservationRepository->getReservationsByEmail($email);

        $this->render("profile", [
            'user' => $user,
            'reservations' => $reservations
        ]);
    }
}
