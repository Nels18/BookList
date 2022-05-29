<?php

namespace App\Model;

use App\Controller\PaginatorController;
use App\Database\Database;

class BookModel
{
    public function getBooks(PaginatorController $paginator): array
    {
        $query = "SELECT b.id, b.title, a.firstname, a.lastname, c.name category, b.publication_date, b.summary  FROM book b
        INNER JOIN author a ON a.id = b.author_id
        INNER JOIN category c ON c.id = b.category_id
        ORDER BY id
        ";
        $query .= $paginator->renderQuery() . ';';

        return Database::getInstance()->query($query);
    }
}
