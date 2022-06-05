<?php

namespace App\Controller;

use App\Chore\Form;
use App\Controller\AbstractController;
use App\Model\AuthorModel;
use App\Model\BookModel;
use App\Model\CategoryModel;
use DateTime;

class AuthorController extends AbstractController
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
        $authors = $this->authorModel->findAll();
        
        $pagination = new PaginatorController($this->authorModel);

        $this->render('author/index', compact('authors') + ['pagination' => $pagination->render()]);
    }

    public function show(int $id)
    {
        // On va chercher 1 livre
        $author = $this->authorModel->findOne($id);

        // On envoie à la vue
        $this->render('author/show', compact('author'));
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

                $data = $this->authorModel->setFirstName($cleanData['author-first-name'])
                    ->setLastName($cleanData['author-last-name'])
                    ->setCreatedAt((new DateTime('now'))->format('Y-m-d H:i:s'));
                    var_dump($this->authorModel);

                $author = $this->authorModel->hydrate($data);
                $author->create();

                $_SESSION['messages'][] = 'L\'auteur a bien été enregistré';
                header('Location: /?p=author/index');
                exit;
            } else {

                // Le formulaire est invalide
                $_SESSION['errors'] = $validation;

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);
            }
        }

        $form = $this->getAuthorForm();

        return $this->render('author/add', ['authorForm' => $form->create()]);
    }

    public function edit(int $id)
    {
        // On va vérifier si l\'auteur existe dans la base

        // On cherche l\'auteur avec l'id $id
        $author = $this->authorModel->findOne($id);

        if (!empty($_POST)) {

            // Si il y a quelque chose dans $_POST on vérifie ce qui a été envoyé
            $validation = $this->validateDataFromUser($_POST);

            // Si le formulaire est valide
            if ($validation === true) {

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);

                $data = $this->authorModel->setFirstName($cleanData['author-first-name'])
                ->setLastName($cleanData['author-last-name'])
                    ->setUpdatedAt((new DateTime('now'))->format('Y-m-d H:i:s'));

                $updatedAuthor = $this->authorModel->hydrate($data);
                $originalAuthor = $this->authorModel->hydrate($author);

                if ($originalAuthor !== $updatedAuthor) {
                    $updatedAuthor->update();

                    $_SESSION['messages'][] = 'L\'auteur a bien été modifié';
                } else {
                    $_SESSION['messages'][] = 'Aucun changement détecté, l\'auteur n\'a pas été modifié';
                }

                header('Location: /?p=author/index');
                exit;
            } else {

                // Le formulaire est invalide
                unset($_SESSION['errors']);
                $_SESSION['errors'] = $validation;

                $cleanData = $this->cleanDataFromUser($_POST);
            }
        }

        $form = $this->getAuthorForm($author);
        return $this->render("author/edit", ['authorForm' => $form->create()]);
    }

    public function remove(int $id)
    {
        $author = $this->authorModel->findOne($id);
        $this->authorModel->delete($id);
        $_SESSION['messages'][] = 'L\'auteur <span class="fw-bold">' . $author['title'] . '</span> a bien été supprimé';
        header('Location: ?p=author/index');
    }

    public function getAuthorForm(mixed $author = null)
    {
        var_dump($author);
        $form = new Form();
        $form->startForm()
            ->startDiv('row')
            ->startDiv('col-md mb-3')
            ->addLabelFor('author-first-name', 'Prénom', ['class' => 'mb-3 form-label'])
            ->addInput('text', 'author-first-name', [
                'class' => 'form-control',
                'id' => 'author-first-name',
            ]
                // Si il y a un titre déja défini, (si on se trouve dans 'edit') on l'ajoute sinon on ajoute rien
                 + (isset($_POST['author-first-name']) ? ['value' => $_POST['author-first-name']] : [])
                 + (isset($author['first_name']) ? ['value' => $author['first_name']] : [])
            )

            ->endDiv()
            ->startDiv('col-md mb-3')
            ->addLabelFor('author-last-name', 'Nom', ['class' => 'mb-3 form-label'])
            ->addInput('text', 'author-last-name', [
                'class' => 'form-control',
                'id' => 'author-last-name',
            ]
                // Si il y a un titre déja défini, (si on se trouve dans 'edit') on l'ajoute sinon on ajoute rien
                 + (isset($_POST['author-last-name']) ? ['value' => $_POST['author-last-name']] : [])
                 + (isset($author['last_name']) ? ['value' => $author['last_name']] : [])
            )

            ->endDiv()
            ->endDiv()
            ->startDiv('col-md-4 my-4')
            ->addButton(isset($author) ? 'Modifier l\'auteur' : 'Ajouter l\'auteur', [
                'class' => 'btn btn-primary w-100',
            ])
            ->endDiv()
            ->endForm();

        return $form;
    }

    public function cleanDataFromUser(array $dataFromUser)
    {
        foreach ($dataFromUser as $field => $value) {
            $dataFromUser[$field] = isset($value) ? strip_tags($value) : '';
        }
        return $dataFromUser;

    }

    public function validateDataFromUser(array $dataFromUser): bool | array
    {
        return Form::validate($dataFromUser, [
            'author-first-name' => ['nom', ['required', 'noSpecialCharacters']],
            'author-last-name' => ['nom', ['required', 'noSpecialCharacters']],
        ]);
    }
}
