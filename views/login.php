<!doctype html>
<html lang="fr">
<head>
    <title>Connexion - Wikifruit</title>
    <!-- Inclusion du contenu du fichier header.php -->
    <?php include VIEWS_DIR . '/partials/header.php';?>

</head>
<body>

    <!-- Inclusion du contenu du fichier menu.php -->
    <?php include VIEWS_DIR . '/partials/menu.php'; ?>


    <div class="container">

        <!--Titre h1-->
        <div class="row my-5">
            <div class="col-12">
                <h1 class=text-center>Connexion - Wikifruit</h1>
            </div>
        </div>

        <div class="row">

            <?php

            // Affichage message de succès s'il existe, sinon affichage formulaire
            if(isset($success)){
                ?>

                <div class="alert alert-success text-center fw-bold"><?= $success ?></div>

            <?php
            } else {

                ?>

                <div class="col-12 col-m-6 mx-auto">

                    <form action="<?= PUBLIC_PATH ?>/connexion/" method="POST">

                        <?php

                        if (isset($errors)){

                            foreach ($errors as $error){

                                echo '<div class="alert alert-danger">' . $error . '</div>';
                            }
                        }

                        ?>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input name="email" id="email" class="form-control" type="text">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Mot de passe</label>
                            <input name="password" id="password" class="form-control" type="password">
                        </div>

                        <div class="mb-3">
                            <input type="submit" class="btn btn-success w-100 btn-lg">
                        </div>

                    </form>

                </div>

            <?php
            }
            ?>

        </div>

    </div>

           <!-- Inclusion du contenu du fichier footer.php -->
    <?php include VIEWS_DIR . '/partials/footer.php'; ?>
</body>
</html>