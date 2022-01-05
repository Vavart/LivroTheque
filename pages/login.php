<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>

    <?php include "../components/header.php" ?>
    
    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">


    <?php
        session_start();
    
        $notification = '';

        if (isset($_REQUEST['connection'])) {
            if ($_REQUEST['connection'] == 'fail') {
                $notification = "Email ou mot de passe incorrect, veuillez réessayer";
            }
        }

        $bookWatched = '';
        if (isset($_REQUEST['book'])) {
            $bookWatched = $_REQUEST['book'];
        }

        $connected = false;
        // Check if the person is already connected
        if (isset($_SESSION['email'])) {
            $connected = true;
            $member_name = $_SESSION['member_name'];
            $notification = "Vous êtes déjà connecté $member_name !";
        }

    ?>
</head>
<body>

    <div class="page">

        <?php include "../components/navbar.php" ?>

        <main class="form-page">

            <div class="header">
                <h1>CONNEXION</h1>
                <p>Pas de compte ? <a href="signup.php">Inscrivez-vous</a></p>
                <p class="notification"><?= $notification ?></p>
            </div>


            <?php 
            
            if (!$connected) { ?>

            <form action="../php/connection.php?book=<?= $bookWatched ?>" method="POST">
                <div class="field">
                    <label for="email">E-mail : </label>
                    <input type="text" name="email" id="email" placeholder="E-mail" required>
                </div>
                <div class="field">
                    <label for="password">Mot de passe : </label>
                    <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                </div>


                <button type="submit">
                    Se connecter
                </button>
            </form>
            
            <?php } ?>

        </main>

    </div>
        

    <?php include "../components/footer.php" ?>
    <script src="../js/navbar.js"></script>
    
</body>
</html>