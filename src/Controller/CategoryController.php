<?php

namespace App\Controller;

use App\Chore\Form;
use App\Controller\AbstractController;
use App\Model\AuthorModel;
use App\Model\BookModel;
use App\Model\CategoryModel;
use DateTime;

class CategoryController extends AbstractController
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
        $categories = $this->categoryModel->findAll();
        
        $pagination = new PaginatorController($this->categoryModel);

        $this->render('category/index', compact('categories') + ['pagination' => $pagination->render()]);
    }

    public function show(int $id)
    {
        // On va chercher 1 livre
        $category = $this->categoryModel->findOne($id);

        // On envoie à la vue
        $this->render('category/show', compact('category'));
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

                $data = $this->categoryModel->setName($cleanData['category-name'])
                    ->setCreatedAt((new DateTime('now'))->format('Y-m-d H:i:s'));

                $category = $this->categoryModel->hydrate($data);
                $category->create();

                $_SESSION['messages'][] = 'Le genre a bien été enregistré';
                header('Location: /?p=category/index');
                exit;
            } else {

                // Le formulaire est invalide
                $_SESSION['errors'] = $validation;

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);
            }
        }

        $form = $this->getCategoryForm();

        return $this->render('category/add', ['categoryForm' => $form->create()]);
    }

    public function edit(int $id)
    {
        // On va vérifier si le genre existe dans la base

        // On cherche le genre avec l'id $id
        $category = $this->categoryModel->findOne($id);

        if (!empty($_POST)) {

            // Si il y a quelque chose dans $_POST on vérifie ce qui a été envoyé
            $validation = $this->validateDataFromUser($_POST);

            // Si le formulaire est valide
            if ($validation === true) {

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);

                $updatedCategory = $this->categoryModel->setId($category['id'])
                    ->setName($cleanData['category-name'])
                    ->setUpdatedAt((new DateTime('now'))->format('Y-m-d H:i:s'));
                    
                $updatedData = $updatedCategory->getName();
                $originalData = $category['name'];
                
                if ($updatedData !== $originalData) {
                    $updatedCategory->update();
            

                    $_SESSION['messages'][] = 'Le genre a bien été modifié';
                } else {
                    $_SESSION['messages'][] = 'Aucun changement détecté, le genre n\'a pas été modifié';
                }

                header('Location: /?p=category/index');
                exit;
            } else {

                // Le formulaire est invalide
                unset($_SESSION['errors']);
                $_SESSION['errors'] = $validation;

                $cleanData = $this->cleanDataFromUser($_POST);
            }
        }

        $form = $this->getCategoryForm($category);
        return $this->render("category/edit", ['categoryForm' => $form->create()]);
    }

    public function remove(int $id)
    {
        $category = $this->categoryModel->findOne($id);
        $this->categoryModel->delete($id);
        $_SESSION['messages'][] = 'Le genre <span class="fw-bold">' . $category['title'] . '</span> a bien été supprimé';
        header('Location: ?p=category/index');
    }

    public function getCategoryForm(mixed $category = null)
    {
        $form = new Form();
        $form->startForm()
            ->startDiv('col-md mb-3')
            ->addLabelFor('category-name', 'Nom', ['class' => 'mb-3 form-label'])
            ->addInput('text', 'category-name', [
                'class' => 'form-control',
                'id' => 'category-name',
            ]
                // Si il y a un titre déja défini, (si on se trouve dans 'edit') on l'ajoute sinon on ajoute rien
                 + (isset($_POST['category-name']) ? ['value' => $_POST['category-name']] : [])
                 + (isset($category['name']) ? ['value' => $category['name']] : [])
            )

            ->endDiv()
            ->startDiv('col-md-4 my-4')
            ->addButton(isset($category) ? 'Modifier le genre' : 'Ajouter le genre', [
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
            'category-name' => ['nom', ['required', 'noSpecialCharacters']],
        ]);
    }
}
