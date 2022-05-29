<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\BookModel;

class BookController extends AbstractController
{
    public $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index(): string | false
    {
        $paginator = new PaginatorController('book');
        $books = $this->bookModel->getBooks($paginator);
        $pagination = $paginator->render();

        $parameters = [
            "paginator" => $paginator,
            "books" => $books,
            "pagination" => $pagination,
        ];

        if ($books === null) {
            return $this->noResults();
        }

        return $this->render("src/View/book/index.php", $parameters);
    }
}
