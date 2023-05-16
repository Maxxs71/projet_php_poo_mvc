<?php

// Fichiers contenant tous les points d'entrées du site(chaque route = une nouvelle page du site)

// Importation et inclusion de la clase "MainController" qui est dans le dossier  "src/Controllers"
use Controllers\MainController;

// On instancie le controleur general qui contient les controleurs de toutes les pages du site
$mainController = new MainController();

// Listes des routes avec leur controlleur
// Chauqe URL correspond a une nouvelle page du site
// "default" est la page par defautsi aucune autre page ne correspind à l'URL demandée (page 404)
switch (ROUTE){


    // Route de la page d'accueil
    case '/';
    $mainController->home();
    break;

    // Route de la page d'accueil
    case '/creer-un-compte/';
    $mainController->register();
    break;

    // Route de la page d'accueil
    case '/connexion/';
        $mainController->login();
        break;

    /**
     * Route de la page deconnexion
     */

    case '/deconnexion/';
        $mainController->logout();
        break;
    // Si aucune des *URL precedentes ne match, c'est la page qui sera appele par defaut
    default:
       $mainController->page404();
        break;
}