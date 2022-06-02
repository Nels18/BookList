<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Chore\Form;
use App\Model\AuthorModel;
use App\Model\BookModel;
use App\Model\CategoryModel;
use DateTime;

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

            // Si il y a quelque chose dans $_POST on vérifie ce qui a été envoyé
            $validation = Form::validate($_POST, [
                'book-author' => ['required'],
                'book-title' => ['required'],
                'book-category' => ['required'],
                'book-published_at' => ['required'],
            ]);

            var_dump($validation);

            // Si le formulaire est valide
            if ($validation === true) {

                // On se protège dees injections XXS
                $title = strip_tags($_POST['book-title']);
                $authorId = strip_tags($_POST['book-author']);
                $categoryId = strip_tags($_POST['book-category']);
                $published_at = strip_tags($_POST['book-published_at']);
                $summary = strip_tags($_POST['book-summary']);

                $data = $this->bookModel->setTitle($title)
                                ->setAuthorId($authorId)
                                ->setCategoryId($categoryId)
                                ->setCreatedAt((new DateTime('now'))->format('Y-m-d H:i:s'))
                                ->setPublishedAt($published_at)
                                ->setSummary($summary);

                $book = $this->bookModel->hydrate($data);
                $book->create();

                $_SESSION['message'] = 'Le livre a bien été enregistré';
                header('Location: /');
                exit;
            }
        }


        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();
        $categoriesForSelect = [];
        foreach ($categories as $category) {
            $categoriesForSelect[$category['id']] = $category['name'];
        }

        $authorModel = new AuthorModel();
        $authors = $authorModel->findAll();
        $authorsForSelect = [];
        foreach ($authors as $author) {
            $authorsForSelect[$author['id']] = $author['first_name'] . ' ' . $author['last_name'];
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
        ->addLabelFor('book-published_at', 'Date de parution', ['class' => 'mb-3 form-label'])
        ->addInput('date', 'book-published_at', [
            'class' => 'form-control',
            'id' => 'book-published_at',
        ])
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-author', ' Auteur', ['class' => 'mb-3 form-label'])
        ->addSelect('book-author', $authorsForSelect,
        [
            'class' => 'form-control',
            'id' => 'book-author',
        ], 'Sélectionner un auteur')
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-category', 'Genre', ['class' => 'mb-3 form-label'])
        ->addSelect('book-category', $categoriesForSelect,
        [
            'class' => 'form-control',
            'id' => 'book-category',
        ], 'Sélectionner un genre')
        ->endDiv()
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-summary', 'Résumé', ['class' => 'mb-3 form-label'])
        ->addTextarea('book-summary', '', [
            'class' => 'form-control',
            'id' => 'book-summary',
            'cols' =>'80',
            'rows' =>'10'
        ])
        ->endDiv()
        ->startDiv('col-md-4 my-3 mx-auto')
        ->addButton('Ajouter le livre', [
            'class' => 'btn btn-primary w-100',
        ])
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
