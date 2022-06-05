<?php
namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\BookModel;

class HomeController extends AbstractController
{
    public $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $books = $this->bookModel->findRandoomBooks();

        $this->render('home/index', compact('books'), 'home');
    }
}