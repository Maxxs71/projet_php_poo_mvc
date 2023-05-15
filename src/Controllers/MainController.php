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
        // Charge la vue "home.php" dans le dossier "views"
        require VIEWS_DIR . '/404.php';
    }
}