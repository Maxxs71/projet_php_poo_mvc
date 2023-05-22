<?php

namespace Controllers;

// Importation des classe utilisées
use DateTime;
use Models\DAO\FruitManager;
use Models\DAO\UserManager;
use Models\DTO\Fruit;
use Models\DTO\User;

/**
 * Classe contenant tous les controleurs de notre site
 */
class MainController{

    /**
     * Controleur de la page d'accueil
     */
    public function home(): void
    {

        // Charge la vue "home.php" dans le dossier "views"
        require VIEWS_DIR . '/home.php';

    }


    /**
     * Controleur de la page d'inscription
     */
    public function register(): void
    {

        // Redirige l'utilisateur sur la pade de l'acceuil
        if(isConnected()){

            header('Location:' . PUBLIC_PATH .  '/');
            die();
        }

        // Traitement du formulaire d'inscription

        // Appel des variables
        if(
            isset($_POST['email']) &&
            isset($_POST['password']) &&
            isset($_POST['confirm-password']) &&
            isset($_POST['firstname']) &&
            isset($_POST['lastname'])
        ){

            // Vérifs
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = 'Adresse email invalide';
            }

            if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/u', $_POST['password'])){
                $errors[] = 'Mot de passe invalide';
            }

            if($_POST['password'] != $_POST['confirm-password']){
                $errors[] = 'La confirmation ne correspond pas au mot de passe';
            }

            if(mb_strlen($_POST['firstname']) < 2 || mb_strlen($_POST['firstname']) > 50){
                $errors[] = 'Le prénom est invalide (entre 2 et 50 caractères)';
            }

            if(mb_strlen($_POST['lastname']) < 2 || mb_strlen($_POST['lastname']) > 50){
                $errors[] = 'Le nom est invalide (entre 2 et 50 caractères)';
            }

            // Si pas d'erreurs
            if(!isset($errors)){



                 // Instanciation du manager des users
                $userManager = new UserManager();

                // Verification si l'email est deja prise
                $checkUser = $userManager->findOneBy('email',$_POST['email']);

                if(!empty($checkUser)){
                    $errors[] = ' Cette adresse email est déja utilisée ! ';
                }else {

                    // Créer un nouvel utilisateur
                    $newUserToInsert = new User();

                    // Date actuelle (pour hydrater la date d'inscription)
                    $today = new DateTime();
                    // Hydratation
                    $newUserToInsert
                        ->setEmail($_POST['email'])
                        ->setPassword(password_hash($_POST['password'],PASSWORD_BCRYPT))
                        ->setFirstname($_POST['firstname'])
                        ->setLastname($_POST['lastname'])
                        ->setRegisterDate( $today )

                    ;




                    // On demande au manager de sauvegarder notre nouvel utilisateur dans la BDD
                    $userManager->save ( $newUserToInsert );

                    // Message de succès
                    $success = 'Votre compte a bien été crée ! ';
                }


            }

        }

        // Charge la vue "home.php" dans le dossier "views"
        require VIEWS_DIR . '/register.php';
    }


    /**
     * Controleur de la page de connexion
     */
    public function login(): void
    {

        // Redirige l'utilisateur sur la pade de l'acceuil
        if(isConnected()){

            header('Location:' . PUBLIC_PATH .  '/');
            die();
        }

        // Appel des variables
        if(
            isset($_POST['email']) &&
            isset($_POST['password'])
        ) {

            // Vérifs
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Adresse email invalide';
            }

            if (!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/u', $_POST['password'])) {
                $errors[] = 'Mot de passe invalide';
            }


            // Si pas d'erreurs
            if(!isset($errors)){

                // Instanciation du manager des utilisateurs
                $userManager = new UserManager();

                // Recuperation du compte correspondant a l'email envoye dans le formulaire
                $userToConnect = $userManager->findOneBy('email', $_POST['email']);



                // Si le compte n'existe pas
                if(empty($userToConnect)){
                    $errors[] = ' Le compte n\'existe pas ';
                }else {

                    // Si le mot de passe n'est pas bon
                    if(password_verify($_POST['password'], $userToConnect->getPassword()) ){

                        $errors [] = ' Le mot de passe n\'est pas le bon mot de passe . ';

                    }else{
                        $_SESSION['user'] =$userToConnect;

                        $success = 'Vous etes bien connecté ! ';

                    }

                }

            }

        }



        require VIEWS_DIR . '/login.php';
    }


    /**
     * Controleur de la page de deconnexion
     */

    public function logout(): void
    {
        // Redirige l'utilisateur sur la page de connexion
        if(!isConnected()){

            header('Location:' . PUBLIC_PATH .  '/connexion/');
            die();
        }

        // Suppression de la variable "user" stockée en session(deconnexion)

        unset( $_SESSION['user']);

        require VIEWS_DIR . '/logout.php';
    }

    /**
     * Controlleur de la page profil
     */

    public function profil(): void
    {

        // Redirige l'utilisateur sur la page de connexion
        if(!isConnected()){

            header('Location:' . PUBLIC_PATH .  '/connexion/');
            die();
        }

        // Charge la vue "profil.php"
        require VIEWS_DIR . '/profil.php';

    }

    /**
     * Controlleur de la page d'ajout d'un fruit
     */

    public function fruitAdd():void
    {

        // Redirige l'utilisateur sur la page de connexion si'il n'est pas connecté
        if(!isConnected()){

            header('Location:' . PUBLIC_PATH .  '/connexion/');
            die();
        }

        // Appel des variables
        if(
            isset($_POST['name']) &&
            isset($_POST['color']) &&
            isset($_POST['origin']) &&
            isset($_POST['price-per-kilo']) &&
            isset($_POST['description'])
        ){

            // Vérifs
            if(mb_strlen($_POST['name']) < 2 || mb_strlen($_POST['name']) > 50){
                $errors[] = 'Nom invalide';
            }

            if(mb_strlen($_POST['color']) < 2 || mb_strlen($_POST['color']) > 50){
                $errors[] = 'Couleur invalide';
            }

            if(mb_strlen($_POST['origin']) < 2 || mb_strlen($_POST['origin']) > 50){
                $errors[] = 'Pays d\'origine invalide';
            }

            if(!preg_match('/^[0-9]{1,7}([.,][0-9]{1,2})?$/', $_POST['price-per-kilo'])){
                $errors[] = 'Prix invalide';
            }

            if(mb_strlen($_POST['description']) < 5 || mb_strlen($_POST['description']) > 10000){
                $errors[] = 'Description invalide';
            }

            // Si pas d'erreurs
            if(!isset($errors)){

                // Création du fruit
                $newFruit = new Fruit();

                //Hydratation du nouveau fruit avec les données du formulaire
                $newFruit
                    ->setName( $_POST['name'] )
                    ->setColor( $_POST['color'] )
                    ->setOrigin( $_POST['origin'] )
                    // Ici on remplace la virgule du prix par un point si l'utilisateur en a mis un, sinon la BDD ne vas pas l'accepter
                    ->setPricePerKilo(str_replace(',' , '.' , $_POST['price-per-kilo'])  )
                    ->setUser( $_SESSION['user'])
                    ->setDescription( $_POST['description'])
                    ;

                // Recuperation du manager des fruits
                $fruitManager = new FruitManager();

                // Sauvegarde du fruit en BDD
                $fruitManager->save($newFruit);


                // Message de succès
                $success = 'Le fruit a bien été ajouté !';

            }

        }

        //Charge  la vue "fruitAdd.php
        require VIEWS_DIR . '/fruitAdd.php';


    }


    /**
     * Controleur de la page qui liste les fruits
     */
    public function fruitList():void
    {

        // Recuperation du manager des fruits
        $fruitsManager = new FruitManager();


        // Recuperation de tous les fruits dans la BDD
        $fruits = $fruitsManager->findAll();




        // Charge la vue "fruitList.php" dans le dossier "views"
        require VIEWS_DIR . '/fruitList.php';
    }

    /**
     * Controleur de la page des details des fruits
     */
    public function fruitDetails(): void
    {

        // Recuperation du manager des fruits
        $fruitManager = new FruitManager();

        // On recupere le fruit dont l'id est stocké dans l'url
        $fruit = $fruitManager->findOneBy('id', $_GET['id']);

        // Si aucun fruits n'a etet trouvé, on affiche la page 404
        if(empty($fruit)){
            $this->page404();
            die();
        }
        // Charge la vue "fruitDetails.php" dans le dossier "views"
        require VIEWS_DIR . '/fruitDetails.php';
    }


    /**
     * Controleur de la page 404
     */
    public function page404(): void
    {
        // Modifie le code HTTP pour qu'il soit bien 404 et non 200
        header('HTTP/1.1.404 NOT FOUND');

        // Charge la vue "home.php" dans le dossier "views"
        require VIEWS_DIR . '/404.php';
    }
}