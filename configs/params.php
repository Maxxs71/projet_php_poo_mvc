<?php
// Fichier contenant les parametres de configuration du site


// Creation d'une constant contenant la route actuelle
define('ROUTE', request_path());

// EMplacement du dossier qui contient les vues du sites
define('VIEWS_DIR', __DIR__ . '/../views');