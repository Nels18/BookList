<?php

namespace App\Controller;

use App\Chore\Form;
use App\Model\UserModel;

class UserController extends AbstractController
{

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Crée la session de l'utilisateur
     * @return void
     */
    public function setSession()
    {
        $_SESSION['user'] = [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles,
        ];
    }

    /**
     * Connexion des utilisateurs
     * @return void
     */
    public function login()
    {

        // On vérifie si le formulaire est complet
        if (!empty($_POST)) {
            $validation = Form::validate($_POST, [
                'user-email' => ['email', ['required']],
                'user-password' => ['mot de passe', ['required']],
            ]);

            // Si le formulaire est valide
            if ($validation === true) {
                // Le formulaire est complet
                // On va chercher dans la base de données l'utilisateur avec l'email entré
                $userFromDB = $this->userModel->findOneByEmail(strip_tags($_POST['user-email']));

                // Si l'utilisateur n'existe pas
                if (!$userFromDB) {
                    // On envoie un message de session
                    $_SESSION['errors'][] = 'L\'adresse e-mail est incorrect';
                    header('Location: /?p=user/login');
                    exit;
                }

                // L'utilisateur existe
                $userFromForm = $this->userModel->hydrate($userFromDB);

                // On vérifie si le mot de passe est correct
                if (password_verify($_POST['user-password'], $userFromForm->getPassword())) {
                    // Le mot de passe est bon
                    // On crée la session
                    $userFromForm->setSession();
                    $_SESSION['messages'][] = 'Vous êtes connecté';
                    header('Location: /');
                    exit;
                } else {
                    // Mauvais mot de passe
                    $_SESSION['errors'][] = 'Le mot de passe est incorrect';
                    header('Location: /?p=user/login');
                    exit;
                }
            } else {

                // Le formulaire est invalide
                $_SESSION['errors'] = $validation;

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);
            }

            // // Le formulaire est complet
            // // On va chercher dans la base de données l'utilisateur avec l'email entré
            // $userModel = new UsersModel;
            // $userArray = $userModel->findOneByEmail(strip_tags($_POST['email']));

            // // Si l'utilisateur n'existe pas
            // if (!$userArray) {
            //     // On envoie un message de session
            //     $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
            //     header('Location: /user/login');
            //     exit;
            // }

            // // L'utilisateur existe
            // $user = $userModel->hydrate($userArray);

            // // On vérifie si le mot de passe est correct
            // if (password_verify($_POST['password'], $user->getPassword())) {
            //     // Le mot de passe est bon
            //     // On crée la session
            //     $user->setSession();
            //     header('Location: /');
            //     exit;
            // } else {
            //     // Mauvais mot de passe
            //     $_SESSION['erreur'] = 'L\'adresse e-mail et/ou le mot de passe est incorrect';
            //     header('Location: /user/login');
            //     exit;
            // }

        }

        $form = new Form;

        $form->startForm()
            ->startDiv('col-md mb-3')
            ->addLabelFor('user-email', 'E-mail :', ['class' => 'mb-3 form-label'])
            ->addInput('email', 'user-email', [
                'class' => 'form-control',
                'id' => 'user-email',
            ]
                 + (isset($_POST['user-email']) ? ['value' => $_POST['user-email']] : [])
            )
            ->endDiv()
            ->startDiv('col-md mb-3')
            ->addLabelFor('user-password', 'Mot de passe :', [
                'class' => 'mb-3 form-label',
            ]
            )
            ->addInput('password', 'user-password', [
                'class' => 'form-control',
                'id' => 'user-password',
            ]
                 + (isset($_POST['user-password']) ? ['value' => $_POST['user-password']] : [])
            )
            ->endDiv()
            ->startDiv('col-md-4 my-4')
            ->addButton('Me connecter', [
                'class' => 'btn btn-primary w-100',
            ]
            )
            ->endDiv()
            ->endForm();

        $this->render('user/login', ['loginForm' => $form->create()]);

    }

    /**
     * Déconnexion de l'utilisateur
     * @return exit
     */
    public function logout()
    {
        // On suprime l'utilisateur de la session
        unset($_SESSION['user']);
        // On redirige vers la page actuelle
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function cleanDataFromUser(array $dataFromUser)
    {
        foreach ($dataFromUser as $field => $value) {
            $dataFromUser[$field] = isset($value) ? strip_tags($value) : '';
        }
        return $dataFromUser;

    }
}
