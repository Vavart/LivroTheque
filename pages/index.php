<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Balises Meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Livrothèque</title>

    <?php include "../components/header.php" ?>

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">

    <?php include "../php/connectionSql.php"  ?>

    <?php 

        session_start();

        $connected = false;
        if (isset($_SESSION['email'])) {
            $connected = true;
        }

    ?>

</head> 
<body>

    <div>
        <div class="main-content">
            <h1>Livrothèque</h1>
            <h2>La bibliothèque des gens curieux</h2>
            
            <div class="cont-links">
                <!-- On aurait théoriquement préféré un lien <a> pour le SEO (mais ça ne marchait pas ...) -->

                <div class="cont-btn-cta">

                        <?php 
                            if ($connected) { ?>
                                <a href="home.php">Voir les livres</a>
                                <?php } else { ?>
                                    <a href="home.php">Voir les livres sans être connecté</a>
                            <?php } ?>
                </div>

                <?php 
                    if (!$connected) { ?>

                        <div class="links">
                            <a href="login.php">Se connecter</a>
                            <a href="signup.php">S'inscrire</a>
                        </div>

                   <?php } ?>
            </div>
        </div>

            <div class="overlay"></div>
            <video autoplay loop muted>
                <source src="../assets/videos/book.mp4"
            type="video/mp4">
        </video>

    </div>

    <!-- À enlever évidemment! -->
    <!-- <a href="adminpage.php">admin</a> -->
    
    
</body>
</html>