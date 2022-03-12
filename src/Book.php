<?php

namespace App;

use App\Database;

class Book
{
    
    private const NB_BOOK_PER_PAGE = 3;

    private function getBooks(Pagination $pagination): array
    {
        $query = "SELECT b.id, b.title, a.firstname, a.lastname, c.name category, b.publication_date, b.summary  FROM book b
        INNER JOIN author a ON a.id = b.author_id
        INNER JOIN category c ON c.id = b.category_id
        ORDER BY id
        ";
        $query .= $pagination->getPaginationRequest(self::NB_BOOK_PER_PAGE) . ';';

        return Database::getInstance()->query($query);
    }

    private function noResults(): string
    {
        return '<p>Aucun résultat trouvé</p>';
    }

    private function printResult(array $books, Pagination $pagination)
    {
        $result = '';

        foreach ($books as $book) {
            $result .= '
            <div class="card p-3 my-5">
                <div class="card-body">
                    <h5 class="card-title"> ' . $book['title'] . ' </h5>
                    <h6 class="card-subtitle mb-2 text-muted"> ' . $book['firstname'] . ' ' . strtoupper($book['lastname']) . ' (' . date('d/m/Y', strtotime($book['publication_date'])) . ')' . ' - ' . $book['category'] . ' </h6>
                    <p class="card-text"> ' . $book['summary'] . ' </p>
                </div>
            </div>';
        }
        $result .= $pagination->getPagination(self::NB_BOOK_PER_PAGE);

        return $result;
    }

    public function readAll(): string
    {
        $pagination = new Pagination('book');

        $books = $this->getBooks($pagination);
        if ($books == null) {
            return $this->noResults();
        }

        return $this->printResult($books, $pagination);
    }
}