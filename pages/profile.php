<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil</title>

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

    $connected = false;
    if (isset($_SESSION['email'])) {
        $connected = true;
    }

    if (!$connected) {
        header("Location: login.php");
    }

    $modify_request = false;
    if (isset($_REQUEST['modify'])) {
        $modify_request = true;
    }

    $notification = '';
    $notification_success = '';
    if (isset($_REQUEST['msg']) ) {

        if ($_REQUEST['msg'] == "noMatch") {

            $notification = "L'ancien mot de passe rentré n'est pas le bon, veuillez re-saisir les informations.";
        }

        elseif ($_REQUEST['msg'] == "success") {
            $notification_success = "Les informations ont bien été modifiées !";
        }

        elseif ($_REQUEST['msg'] == "deleteFailed") {
            $notification = "Veuillez rendre vos livres empruntés avant de 
            supprimer votre compte.";
        }

    }
    
    ?>
</head>
<body>

    <div class="page">

        <?php include "../components/navbar.php" ?>
        

        <div class="cont-titre">
            <h1>Mes informations personnelles</h1>
            <p>Vous pouvez les modifier à tout moment !</p>
            <p class="notification">
                <?= $notification ?>
            </p>
            <p class="notification--success">
                <?= $notification_success ?>
            </p>
            
            <hr>
        </div>

        <?php
        
            if (!$connected) {

            }
        
        ?>

       <?php if (!$modify_request) { ?>
            <main class="readonly">
                <form action="" method="POST" class="personal-infos">

                    <div class="field">
                        <label for="id">Numéro d'adhérent :</label>
                        <input type="text" name="id" id="id" readonly value='<?= $_SESSION['id_membre'] ?>'>
                    </div>
                    <div class="field">
                        <label for="surname">Nom :</label>
                        <input type="text" name="surname" id="surname" readonly value='<?= $_SESSION['surname'] ?>'>
                    </div>
                    <div class="field">
                        <label for="name">Prénom :</label>
                        <input type="email" name="name" id="name" readonly value='<?= $_SESSION['member_name'] ?>'>
                    </div>
                    <div class="field">
                        <label for="email">E-mail :</label>
                        <input type="email" name="email" id="email" readonly value='<?= $_SESSION['email'] ?>'>
                    </div>
                    <div class="field">
                        <label for="password">Mot de passe :</label>
                        <input type="password" name="password" id="password" readonly 
                        value =

                        <?php 
                        $fake_mdp = str_repeat('*', 15);
                        echo $fake_mdp;

                        ?>
                        >
                    </div>
        
                    <div class="modify-infos">
                        <a href="profile.php?modify=true">Modifier</a>
                    </div>
                </form>


                <!-- Début modale zone de danger -->
                <div class="danger-overlay"></div>
                <div class="danger-modal">
                    <div class="inner-modal">
                        <h4>Êtes-vous vraiment sûr de vouloir supprimer votre compte ?</h4>
                        <p>Vous allez nous manquer !</p>

                        <form action="../php/deleteProfile.php" method="POST" class="form-danger-zone">
                            <button type="submit">Supprimer mon compte</button>
                        </form>
                        <button class="close-danger-modal">X</button>
                    </div>
                </div>
                <!-- Fin modale zone de danger -->

                <div class="danger-zone">
                    <h3>Zone de danger</h3>

                    <div class="delete-account">
                        <p>Supprimer mon compte : </p>
                        <button type="button" class="open-danger-modal">Supprimer mon compte</button>
                    </div>
                </div>
                <p class="delete-note">Note : Vous ne pourrez pas supprimer votre compte si vous avez des emprunts en cours. Tout votre historique sera supprimé.</p>


            </main>


        <?php } else { ?>
            <main class="modified">
                <p class="info">Réécrire votre ancien mot de passe nous permet de vérifier qu'il s'agit bien de vous.</p>
                <form action="../php/updateProfile.php" method="POST" class="modify-personal-infos">

                    <input type="hidden" name="changePassword" value="false">
                    <div class="field-left">
                        <div class="field">
                            <label for="email">Email*</label>
                            <input type="email" name="email" id="email" placeholder="Email" required value='<?= $_SESSION['email'] ?>'>
                        </div>
                        <div class="field">
                            <label for="oldPassword">Ancien mot de passe*</label>
                            <input type="password" name="oldPassword" id="oldPassword" placeholder="Ancien mot de passe" required>
                        </div>

                        <button type="button" id="active-createNewPassword">Changer mon mot de passe</button>

                        <div class="createNewPassword">
                            <div class="field">
                                <label for="newPassword">Nouveau mot de passe*</label>
                                <input type="password" name="newPassword" id="newPassword" placeholder="Nouveau mot de passe" >
                            </div>
                            <div class="field">
                                <label for="confirmNewPassword">Confirmer le nouveau mot de passe*</label>
                                <input type="password" name="confirmNewPassword" id="confirmNewPassword" placeholder="Confirmer le nouveu mot de passe" >
                            </div>
                        </div>

                        
                    </div>

                    <div class="field-right">
                        <div class="field">
                            <label for="surname">Nom*</label>
                            <input type="text" name="surname" id="surname" placeholder="Nom" required value='<?= $_SESSION['surname'] ?>'>
                        </div>
                        <div class="field">
                            <label for="name">Prénom*</label>
                            <input type="text" name="name" id="name" placeholder="Prénom" required value='<?= $_SESSION['member_name'] ?>'>
                        </div>


                        <div class="password-requirements createNewPassword">
                            <h2>Mot de passe :</h2>
                            <ul>
                                <li class="validated-chars">8 caractères minimum</li>
                                <li class="validated-majmin">Majuscules et minuscules</li>
                                <li class="validated-figure">Au moins 1 chiffre</li>
                                <li class="validated-specialchar">Au moins 1 caractère spécial</li>
                                <li class="validated-password">Les deux mots de passe correspondent</li>
                            </ul>
                        </div>


                        <div class="cont-btns">
                            <a href="profile.php" class="cancel-modifs">
                                Annuler les modifications
                            </a>
                            <button type="submit">
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </div>

                    
                </form>
            </main>
        <?php } ?> 

  
    </div>
        

    <?php include "../components/footer.php" ?>

    <script src="../js/navbar.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../js/profile_modal.js"></script>
    
</body>
</html>