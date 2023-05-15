<?php

namespace Controllers;


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