<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>

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

        $notification = "";
        if (isset($_REQUEST["email"])) {
            $notification = "L'adresse mail utilisée est déjà associée à un autre compte. Veuillez réessayer.";
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



        <main class="form-page inscription">

            <div class="header">
                <h1>INSCRIPTION</h1>
                <p>Déjà un compte ? <a href="login.php">Connectez-vous</a></p>
                <p class="notification"><?= $notification ?></p>
            </div>


        <?php 
            if (!$connected) { ?>

            <form action="../php/inscription.php" method="POST" id="form_signup">

                <div class="field-left">
                    <div class="field">
                        <label for="email">Email*</label>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="field">
                        <label for="password">Mot de passe*</label>
                        <input type="password" name="password" id="password" placeholder="Mot de passe" required>
                    </div>
                    <div class="field">
                        <label for="confirm-password">Confirmer le mot de passe*</label>
                        <input type="password" name="confirmPassword" id="confirm-password" placeholder="Confirmer le mot de passe" required>
                    </div>
                    <button type="submit">
                        S'inscrire
                    </button>
                </div>

                <div class="field-right">
                    <div class="field">
                        <label for="surname">Nom*</label>
                        <input type="text" name="surname" id="surname" placeholder="Nom" required>
                    </div>
                    <div class="field">
                        <label for="name">Prénom*</label>
                        <input type="text" name="name" id="name" placeholder="Prénom" required>
                    </div>

                    <div class="password-requirements">
                        <h2>Mot de passe :</h2>
                        <ul>
                            <li class="validated-chars">8 caractères minimum</li>
                            <li class="validated-majmin">Majuscules et minuscules</li>
                            <li class="validated-figure">Au moins 1 chiffre</li>
                            <li class="validated-specialchar">Au moins 1 caractère spécial</li>
                            <li class="validated-password">Les deux mots de passe correspondent</li>
                        </ul>
                    </div>
                </div>

                
            </form>

            <?php } ?>

        </main>

    </div>
        

    <?php include "../components/footer.php" ?>

    <script src="../js/navbar.js"></script>
    <script src="../js/signup.js"></script>
    
</body>
</html>