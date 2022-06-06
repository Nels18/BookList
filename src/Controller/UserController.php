<?php

namespace App\Controller;

use App\Chore\Form;
use App\Model\UserModel;
use DateTime;

class UserController extends AbstractController
{
    public $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
                $passwordIsCorrect = password_verify($_POST['user-password'], $userFromForm->getPassword());
                if ($passwordIsCorrect) {
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
        }

        $form = new Form;

        $form->startForm()
            ->startDiv('row')
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

    public function register()
    {
        // On vérifie si le formulaire est complet
        if (!empty($_POST)) {
            $validation = Form::validate($_POST, [
                'user-first_name' => ['first_name', ['required']],
                'user-last_name' => ['last_name', ['required']],
                'user-email' => ['email', ['required']],
                'user-password' => ['mot de passe', ['required']],
            ]);

            // Si le formulaire est valide
            if ($validation === true) {

                // On "nettoie" l'adresse email
                $cleanData = $this->cleanDataFromUser($_POST);

                $userFromDB = $this->userModel->findOneByEmail(strip_tags($_POST['user-email']));

                // Si l'utilisateur n'existe pas
                if ($userFromDB) {
                    // On envoie un message de session
                    $_SESSION['errors'][] = 'Cet email est déjà attribuée à un autre utilisateur. Si cet email vous appartient veuillé vous connecter';

                    header('Location: /?p=user/register');
                    exit;
                }

                // On chiffre le mot de passe
                $password = password_hash($_POST['user-password'], PASSWORD_ARGON2I);


                $this->userModel->setFirstName($cleanData['user-first_name'])
                    ->setLastName($cleanData['user-last_name'])
                    ->setEmail($cleanData['user-email'])
                    ->setPassword($password)
                    ->setRoles("['ROLE_USER']")
                    ->setCreatedAt((new DateTime('now'))->format('Y-m-d H:i:s'));

                // On stocke l'utilisateur
                $this->userModel->create();
                $_SESSION['messages'][] = 'Vous êtes inscrit, veuillez-vous connecter';
                header('Location: /?p=user/login');
                exit;
            } else {

                // Le formulaire est invalide
                $_SESSION['errors'] = $validation;

                // On se protège dees injections XXS
                $cleanData = $this->cleanDataFromUser($_POST);
            }
        }

        $form = new Form;


        $form->startForm()
            ->startDiv('row')
            ->startDiv('col-md mb-3')
            ->addLabelFor('user-first_name', 'Prénom', ['class' => 'mb-3 form-label'])
            ->addInput('text', 'user-first_name', [
                    'class' => 'form-control',
                    'id' => 'user-first_name',
                ]
                // Si il y a un prénom déja défini dans , on l'ajoute sinon on ajoute rien
                + (isset($_POST['user-first_name']) ? ['value'  => $_POST['user-first_name']] : [])
            )
            ->endDiv()
            ->startDiv('col-md mb-3')
            ->addLabelFor('user-last_name', 'Nom', ['class' => 'mb-3 form-label'])
            ->addInput('text', 'user-last_name', [
                    'class' => 'form-control',
                    'id' => 'user-last_name',
                ]
                // Si il y a un nom déja défini dans , on l'ajoute sinon on ajoute rien
                + (isset($_POST['user-last_name']) ? ['value'  => $_POST['user-last_name']] : [])
            )
            ->endDiv()
            ->endDiv()
            ->startDiv('row')
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
            ->endDiv()
            ->startDiv('col-md-4 my-4')
            ->addButton('M\'inscrire', [
                    'class' => 'btn btn-primary w-100',
                ]
            )
            ->endDiv()
            ->endForm();

        $this->render('user/register', ['registerForm' => $form->create()]);
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
            if ($field === 'user_password') {
                $dataFromUser[$field] = isset($value) ? strip_tags($value) : '';
            }
        }
        return $dataFromUser;
    }
}
