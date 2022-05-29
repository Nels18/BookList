<?php

namespace App\Controller;

use App\Controller\BookController;

class BaseController
{

    private $content = 'contenu';

    public function __construct()
    {
        $book = new BookController();
        $this->content = $book->index();
    }

    public function getContent(): string
    {
        if (!$this->content) {
            return false;
        };
        
        return $this->content;
    }

    public function setContent(string $newContent)
    {
        $this->content = $newContent;
    }
}
