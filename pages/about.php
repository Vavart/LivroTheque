<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos</title>

    <?php include "../components/header.php" ?>

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- PHP -->
    <?php
    session_start();
    
    ?>
</head>
<body>

    <div class="page">

        <?php include "../components/navbar.php" ?>

        <h1 class="title">À Propos de la Livrothèque</h1>
        <hr>

        <p class="description-about">Ce site été conçu dans le cadre de l’UE “Technologies de l’internet” à l’ENSIM. <br><br><br>

            La Livrothèque est un site permettant la consultation et l'emprunt de livres orientés sur le développement personnel, financier et entrepreneurial. Seuls les adhérents peuvent emprunter ces livres, qu'ils viennent ensuite chercher en bibliothèque. Les emprunts sont limités à 3 livres par adhérent. <br><br><br>
            
            Une partie administration est aussi présente, afin de gérer stocks et emprunts des adhérents :-) <br><br><br>
            
            Fait avec le 💖 par Maxime Sciare <br><br>
            <span>Github & LinkedIn :</span>
        </p>

            <div class="cont-medias">
                <a href="https://github.com/Vavart"><img src="../assets/pictures/github.svg" alt="github icon"></a>
                <a href="https://www.linkedin.com/in/maximesciare/"><img src="../assets/pictures/linkedin.svg" alt="linkedin icon"></a>
            </div>

            <div class="cont-btn-cta">
                <a href="home.php" class="btn-redirection">Retour à l'accueil</a>
            </div>

    </div>
        

    <?php include "../components/footer.php" ?>

    <script src="../js/navbar.js"></script>
    
</body>
</html>