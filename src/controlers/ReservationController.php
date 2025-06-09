<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/BookRepository.php';

class ReservationController extends AppController
{
    public function reserve()
    {
        if (!$this->isLoggedIn()) {
            http_response_code(403);
            echo json_encode(["message" => "Unauthorized"]);
            return;
        }

        if ($this->getRequestMethod() !== 'POST') {
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed"]);
            return;
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $bookId = (int) ($input['bookId'] ?? 0);
        $libraryName = trim($input['library'] ?? '');

        if (!$bookId || !$libraryName) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid input"]);
            return;
        }

        require_once __DIR__ . '/../repository/ReservationRepository.php';
        require_once __DIR__ . '/../repository/LibraryRepository.php';

        $libraryRepo = new LibraryRepository();
        $reservationRepo = new ReservationRepository();

        $library = $libraryRepo->getByName($libraryName);

        if (!$library) {
            http_response_code(404);
            echo json_encode(["message" => "Library not found"]);
            return;
        }

        $code = $reservationRepo->makeReservation($bookId, $library['id'], $_SESSION['user']["email"]);

        if ($code) {
            echo json_encode(["message" => "Book reserved successfully. Reservation code: $code"]);
        } else {
            http_response_code(409);
            echo json_encode(["message" => "Book is not available in selected library."]);
        }
    }
}
