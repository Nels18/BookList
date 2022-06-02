<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Chore\Form;
use App\Model\BookModel;
use App\Model\CategoryModel;

class BookController extends AbstractController
{
    public $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $books = $this->bookModel->findAll();
        // $paginator = new PaginatorController('book');
        // $books = $this->bookModel->getBooks($paginator);
        // $pagination = $paginator->render();

        // $parameters = [
        //     "paginator" => $paginator,
        //     "books" => $books,
        //     "pagination" => $pagination,
        // ];

        $this->render('book/index', compact('books'));

    }

    public function show(int $id)
    {
        // On va chercher 1 book
        $book = $this->bookModel->findOne($id);

        // On envoie à la vue
        $this->render('book/show', compact('book'));
    }

    public function add()
    {
        if (!empty($_POST)) {
            Form::validate($_POST, [
                'author' => ['required','noSpecialCharacters'],
                'book-title' => ['required'],
            ]);
            // Form::validate($_POST, 'book-title', ['required']);
        }


        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();
        $categoriesForSelect = [];
        foreach ($categories as $category) {
            $categoriesForSelect[$category->id] = $category->name;
        }

        $form = new Form();
        $form->startForm()
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-title', 'Titre', ['class' => 'mb-3 form-label'])
        ->addInput('text', 'book-title', [
            'class' => 'form-control',
            'id' => 'book-title',
        ])
        ->endDiv()
        ->startDiv('row')
        ->startDiv('col-md mb-3')
        ->addLabelFor('publication_date', 'Date de parution', ['class' => 'mb-3 form-label'])
        ->addInput('date', 'publication_date', [
            'class' => 'form-control',
            'id' => 'publication_date',
        ])
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('author', ' Auteur', ['class' => 'mb-3 form-label'])
        ->addInput('text', 'author', [
            'class' => 'form-control',
            'id' => 'author',
        ])
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('category', 'Genre', ['class' => 'mb-3 form-label'])
        ->addSelect('category', $categoriesForSelect,
        [
            'class' => 'form-control',
            'id' => 'author',
        ], 'Sélectionner un genre')
        ->endDiv()
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('summary', 'Résumé', ['class' => 'mb-3 form-label'])
        ->addTextarea('summary', '', [
            'class' => 'form-control',
            'id' => 'summary',
            'cols' =>'80',
            'rows' =>'10'
        ])
        ->endDiv()
        ->startDiv('d-md-flex justify-content-between flex-column flex-md-row')
        ->startDiv('my-3')
        ->addButton('Ajouter le livre', [
            'class' => 'btn btn-primary w-100',
        ])
        ->endDiv()
        ->startDiv('my-3')
        ->addButton('Annuler', [
            'class' => 'btn btn-danger w-100'
        ])
        ->endDiv()
        ->endDiv()
        ->endForm();

        return $this->render('book/add', ['bookForm' => $form->create()]);
    }

    // public function edit()
    // {
    //     return $this->render("book/edit");
    // }

    // public function remove()
    // {
    // }

}
