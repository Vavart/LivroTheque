<?php

$connected = false;
$admin = false;

if (isset($_SESSION['email'])) {
    $connected = true;
}

// If we're on the admin page, there's no need to have navlinks
if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
    $admin = true;
}
?>

<nav>
    <div class="cont-nav">
        <div class="cont-logo">
            <a href="index.php">
                <img src="../assets/pictures/logo.svg" alt="logo" class="logo">
            </a>
        </div>
        
        <?php 

        if (!$admin) { ?>

            <div class="nav-links">
                <a href="home.php" class="nav-link">Accueil</a>
                <a href="about.php" class="nav-link">À Propos</a>
                <a href="search.php" class="nav-link">Recherche</a>

                <?php 
                if ($connected) { ?>

                    <a href="loanpage.php" class="nav-link">Mes emprunts</a>                   
                    <a href="profile.php" class="nav-link">Mon compte </a>
                    <a href="../php/deconnection.php" class="nav-link">Se déconnecter</a>
                                                     
                <?php } ?>

                <?php 
                if (!$connected) { ?>

                <a href="login.php" class="nav-link">Se connecter</a>
                <a href="signup.php" class="nav-link">S'inscrire</a>
                    
                <?php } ?>

                
            </div>

            <?php } elseif ($admin && $connected) { ?>

            <div class="nav-links adminNav">
                <a href="../php/deconnection.php" class="nav-link">Se déconnecter</a>

            </div>
                    
                <?php  } ?>

            <button class="btn-responsive-nav">
                <img src="../assets/pictures/menu.svg" alt="hamburger menu icon">
            </button>
    </div>
</nav>