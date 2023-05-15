<!doctype html>
<html lang="fr">
<head>
    <title>Accueil - Wikifruit</title>
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
                <h1 class=text-center>Accueil - Wikifruit</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-12 mb-5">

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet at aut eaque eveniet ex exercitationem facere illum ipsum, iure labore, laboriosam laudantium maxime pariatur quaerat quidem quos sequi sit soluta! Aliquam autem consequatur, dolore eaque earum error est fugit ipsam ipsum minus non odio odit porro quis ratione, rem repellendus repudiandae saepe similique sint sit sunt totam veniam, vero vitae.</p>

                <div class="d-flex justify-content-around flex-wrap home-fruits">
                    <img src="<?= PUBLIC_PATH ?>/images/banane.jpg" alt="">
                    <img src="<?= PUBLIC_PATH ?>/images/kiwi.jpg" alt="">
                    <img src="<?= PUBLIC_PATH ?>/images/orange.jpg" alt="">
                </div>

            </div>

        </div>

    </div>

           <!-- Inclusion du contenu du fichier footer.php -->
    <?php include VIEWS_DIR . '/partials/footer.php'; ?>
</body>
</html>