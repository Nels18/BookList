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
        $booksModels = $this->bookModel->findAll();
        
        $books = [];
        
        foreach ($booksModels as $book) {
            $books[] = [
                'id' => $book['id'],
                'title' => $book['title'],
                'category' => $this->categoryModel->findOne($book['category_id']),
                'author' => $this->authorModel->findOne($book['author_id']),
                'published_at' => $book['published_at'] ,
                'summary' => $book['summary'] ,
            ];
        };

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
        // On va chercher 1 livre
        $book = $this->bookModel->findOne($id);


        // On va chercher la catégory correspondante
        $category = $this->categoryModel->findOne($book['category_id']);
        
        // On va chercher l'auteur correspondant
        $author = $this->authorModel->findOne($book['author_id']);

        // On envoie à la vue
        $this->render('book/show', compact('book', 'category', 'author'));
    }

    public function add()
    {
        if (!empty($_POST)) {

            // Si il y a quelque chose dans $_POST on vérifie ce qui a été envoyé
            $validation = $this->validateDataFromUser($_POST);


            // Si le formulaire est valide
            if ($validation === true) {

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);

                $data = $this->bookModel->setTitle($cleanData['book-title'])
                                        ->setAuthorId($cleanData['book-author'])
                                        ->setCategoryId($cleanData['book-category'])
                                        ->setCreatedAt((new DateTime('now'))->format('Y-m-d H:i:s'))
                                        ->setPublishedAt($cleanData['book-published_at'])
                                        ->setSummary($cleanData['book-summary']);

                $book = $this->bookModel->hydrate($data);
                $book->create();

                $_SESSION['messages'][] = 'Le livre a bien été enregistré';
                header('Location: /?p=book/index');
                exit;
            } else {

                // Le formulaire est invalide
                $_SESSION['errors'] = $validation;
                
                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);
            }
        }

        $form = $this->getBookForm();

        return $this->render('book/add', ['bookForm' => $form->create()]);
    }

    public function edit(int $id)
    {
        // On va vérifier si le livre existe dans la base

        // On cherche le livre avec l'id $id
        $book = $this->bookModel->findOne($id);

        if (!empty($_POST)) {

            // Si il y a quelque chose dans $_POST on vérifie ce qui a été envoyé
            $validation = $this->validateDataFromUser($_POST);


            // Si le formulaire est valide
            if ($validation === true) {

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);

                $data = $this->bookModel->setTitle($cleanData['book-title'])
                                        ->setId($book['id'])
                                        ->setAuthorId($cleanData['book-author'])
                                        ->setCategoryId($cleanData['book-category'])
                                        ->setUpdatedAt((new DateTime('now'))->format('Y-m-d H:i:s'))
                                        ->setPublishedAt($cleanData['book-published_at'])
                                        ->setSummary($cleanData['book-summary']);

                $updatedBook = $this->bookModel->hydrate($data);
                $originalBook = $this->bookModel->hydrate($book);
                
                if ($originalBook !== $updatedBook) {
                    $updatedBook->update();
    
                    $_SESSION['messages'][] = 'Le livre a bien été modifié';
                } else {
                    $_SESSION['messages'][] = 'Aucun changement détecté, le livre n\'a pas été modifié';
                }
                
                header('Location: /?p=book/index');
                exit;
            } else {

                // Le formulaire est invalide
                unset($_SESSION['errors']);
                $_SESSION['errors'] = $validation;
                
                $cleanData = $this->cleanDataFromUser($_POST);
            }
        }

        $form = $this->getBookForm($book);
        return $this->render("book/edit", ['bookForm' => $form->create()]);
    }

    public function remove(int $id)
    {
        $book = $this->bookModel->findOne($id);
        $this->bookModel->delete($id);
        $_SESSION['messages'][] = 'Le livre <span class="fw-bold">' . $book['title'] . '</span> a bien été modifié';
        header('Location: ?p=book/index');
    }

    public function getBookForm(mixed $book = null)
    {
        $categories = $this->categoryModel->findAll();
        $categoriesForSelect = [];
        foreach ($categories as $category) {
            $categoriesForSelect[$category['id']] = $category['name'];
        }

        $authors = $this->authorModel->findAll();
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
            ]
            // Si il y a un titre déja défini, (si on se trouve dans 'edit') on l'ajoute sinon on ajoute rien
            + (isset($_POST['book-title']) ? ['value'  => $_POST['book-title']] : [])
            + (isset($book['title']) ? ['value'  => $book['title']] : [])
        )
        ->endDiv()
        ->startDiv('row')
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-published_at', 'Date de parution', ['class' => 'mb-3 form-label'])
        ->addInput('date', 'book-published_at', [
            'class' => 'form-control',
            'id' => 'book-published_at',
            ]
            // Si il y a un titre déja défini, (si on se trouve dans 'edit') on l'ajoute sinon on ajoute rien
            + (isset($_POST['book-published_at']) ? ['value'  => $_POST['book-published_at']] : [])
            + (isset($book['published_at']) ? ['value'  => $book['published_at']] : [])
        )

        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-author', ' Auteur', ['class' => 'mb-3 form-label']);

        $authorBook = isset($_POST['book-author']) ?
        $_POST['book-author'] : 
        (isset($book['author_id']) ? $book['author_id'] : '');
        
        $form->addSelect('book-author', $authorsForSelect,
            [
                'class' => 'form-control',
                'id' => 'book-author',
            ],
        'Sélectionner un auteur', $authorBook)
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-category', 'Genre', ['class' => 'mb-3 form-label']);

        $categoryBook = isset($_POST['book-category']) ?
        $_POST['book-category'] : 
        (isset($book['category_id']) ? $book['category_id'] : '');

        $form->addSelect('book-category', $categoriesForSelect,
            [
                'class' => 'form-control',
                'id' => 'book-category',
            ],
        'Sélectionner un genre', $categoryBook)
        ->endDiv()
        ->endDiv()
        ->startDiv('col-md mb-3')
        ->addLabelFor('book-summary', 'Résumé', ['class' => 'mb-3 form-label']);

        // Si il y a un résumé déja défini, (si on se trouve dans 'edit') on l'ajoute sinon on ajoute rien
        $summaryBook = isset($_POST['book-summary']) ?
                    $_POST['book-summary'] : 
                    (isset($book['summary']) ? $book['summary'] : '');

        $form->addTextarea('book-summary',$summaryBook,
            [
                'class' => 'form-control',
                'id' => 'book-summary',
                'cols' =>'80',
                'rows' =>'10'
            ]
        )
        ->endDiv()
        ->startDiv('col-md-4 my-4')
        ->addButton(isset($book) ? 'Modifier le livre' : 'Ajouter le livre', [
            'class' => 'btn btn-primary w-100',
        ])
        ->endDiv()
        ->endForm();

        return $form;
    }

    public function cleanDataFromUser(array $dataFromUser)
    {
        foreach ($dataFromUser as $field => $value) {
            $dataFromUser[$field] = isset($value) ? strip_tags($value) : '' ;
        }
        return $dataFromUser;
        
    }

    public function validateDataFromUser(array $dataFromUser): bool|array
    {
        return Form::validate($dataFromUser, [
            'book-author' => ['auteur', ['required']],
            'book-title' => ['titre', ['required']],
            'book-category' => ['genre', ['required']],
            'book-published_at' => ['date de parution', ['required']],
        ]);
    }
}
