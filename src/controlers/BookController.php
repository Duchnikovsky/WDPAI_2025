<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/BookRepository.php';

class BookController extends AppController
{
    public function books()
    {
        if ($this->getRequestMethod() !== 'POST') {
            http_response_code(405);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $page = isset($data['page']) ? (int) $data['page'] : 1;
        $search = isset($data['search']) ? trim($data['search']) : '';
        $category = $data['category'] ?? '';

        $repo = new BookRepository();
        $booksPerPage = 15;
        $total = $repo->countBooks($search, $category);
        $books = $repo->getBooks($page, $booksPerPage, $search, $category);

        echo json_encode([
            'books' => $books,
            'totalPages' => ceil($total / $booksPerPage),
            'currentPage' => $page
        ]);
    }

    public function addBook()
    {
        if (!$this->isLoggedIn() || !$this->isAdmin() || $this->getRequestMethod() !== 'POST') {
            header("Location: /dashboard");
            exit;
        }

        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $categoryId = $_POST['category'] ?? 0;
        $libraryId = $_POST['library'] ?? 0;
        $quantity = $_POST['quantity'] ?? 0;

        if (!$title || !$author || !$categoryId || !$libraryId || $quantity <= 0) {
            $this->render('dashboard', ['addError' => 'Invalid input']);
            return;
        }

        $repo = new BookRepository();

        $bookId = $repo->findBookId($title, $author, $categoryId);
        if (!$bookId) {
            $bookId = $repo->addBook($title, $author, $categoryId);
        }

        $repo->addToLibrary($bookId, $libraryId, $quantity);

        header("Location: /dashboard");
        exit;
    }
}
