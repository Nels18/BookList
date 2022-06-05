<?php
namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\AuthorModel;
use App\Model\BookModel;
use App\Model\CategoryModel;

class HomeController extends AbstractController
{
    public $bookModel;
    public $categoryModel;
    public $authorModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
        $this->authorModel = new AuthorModel();
    }

    public function index()
    {
        $books = $this->bookModel->findRandoomBooks();
        $authors = $this->authorModel->findRandoomResources('author');
        $categories = $this->categoryModel->findRandoomResources('category');

        $this->render('home/index', compact('books', 'authors',
        'categories'), 'home');
    }
}