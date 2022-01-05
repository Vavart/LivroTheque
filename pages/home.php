<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>

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

    // Je me connecte
    include "../php/connectionSql.php";

    $member_name = "";

    if (isset($_SESSION['email'])) {
        $member_name = $_SESSION['member_name'];

        // Récupération des livres empruntés
        $query = "SELECT livre.pic, livre.ISBN, reservations.currentlyLoaned FROM membre, reservations, livre WHERE (membre.member_name = '$member_name' AND reservations.id_membre = membre.id AND livre.ISBN = reservations.ISBN AND reservations.currentlyLoaned=1)";
        $result = $connect->query($query);
        $loaned_books = $result->fetch_all(MYSQLI_ASSOC);
    }

    // Je pose mes queries
    $query = "SELECT * FROM livre, stock WHERE livre.ISBN = stock.ISBN ORDER BY livre.add_date DESC";

    // Je fetch
    $result = $connect->query($query);
    $books = $result->fetch_all(MYSQLI_ASSOC);
    $i = 0;

    foreach($books as $book) {
        foreach($book as $propkey => $propvalue) {
            $books[$i][$propkey] = htmlspecialchars($propvalue,ENT_QUOTES);
        }

        $i++;
    }
    
    $categories_french = array(
        'self-help' => 'Développement Personnel',
        'finance' => 'Finances',
        'entrepreneurship' => 'Entrepreneuriat',
        'politics' => 'Politique'
    );

    $notification = '';
    if (isset($_REQUEST['msg'])) {
        if ($_REQUEST['msg'] == 'accessDenied') {
            $notification = "Vous n'avez pas acccès à cette partie du site.";
        }
    }
    
    
    ?>

</head>
<body>

    <div class="page">

        <?php include "../components/navbar.php" ?>


        <?php if (isset($_REQUEST['msg'])) { ?>
            <div class="notification">
                <p class="notif"><?= $notification ?></p>
            </div>
        <?php } ?>

        
        <div class="connection-info-container">

            <div class="connection-info">
                
                <?php 
                
                if ($member_name == "") { ?>
                    <p><span>Navigation en tant qu'invité !</span><br> <a href="login.php">Connectez-vous</a> pour bénéficier de toutes les fonctionnalités de la LivroThèque</p>
                    <?php } 

                else { ?>
                <p><span>Bienvenue <?= $member_name ?> !</span><br> Quel plaisir de vous revoir !</p>
                <?php } ?>
                
            </div>



            <?php if ($member_name == "Admin") { ?>

            <div class="admin-btn">
                <a href="adminpage.php" class="btn-cta">Consulter les stocks et emprunts</a>
            </div>

            <?php } ?>

            
        </div>
        
        <main class="main-grid">
            
            <div class="search-fields">
                <h3>Critères de recherche</h3>

                <form action="search.php" method="GET" class="search-criterias">

                    <div class="criteria">

                        <h4>Type : </h4>
                        <div class="cont-labels">

                            <div class="cont-label">
                                <label for="all">Tout</label>
                                <input type="checkbox" name="all" id="all" checked>
                            </div>
                            
                            <div class="cont-label">
                                <label for="self-help">Développement Personnel</label>
                                <input type="checkbox" name="self-help" id="self-help">
                                
                            </div>
                            
                            <div class="cont-label">
                                <label for="finance">Finances</label>
                                <input type="checkbox" name="finance" id="finance">
                            </div>
                            
                            <div class="cont-label">
                                <label for="entrepreneurship">Entrepreneuriat </label>
                                <input type="checkbox" name="entrepreneurship" id="entrepreneurship">
                            </div>
                            <div class="cont-label">
                                <label for="politics">Politique </label>
                                <input type="checkbox" name="politics" id="politics">
                            </div>
                        </div>

                    </div>

                    <div class="criteria c2">
                        <h4>Disponibles uniquement : </h4>
                        <input type="checkbox" name="dispo-only" id="dispo-only">
                    </div>

                    <div class="criteria c2">
                        <h4>Nouveautés à venir : </h4>
                        <input type="checkbox" name="new-only" id="new-only">
                    </div>
                    
                    <button type="submit" class="btn-cta">Rechercher</button>
                </form>
            </div>

            <div class="search-bar home-search-bar">
                <h1>Bievenue dans la Livrothèque !</h1>
            </div>

            
            
                
                <div class="redirection-info">
                    <h3>Où souhaitez-vous aller <?= $member_name ?> ?</h3>
                    <p>Choisissez une catégorie ou commencez directement à rechercher un livre !</p>
                </div>

                <div class="loan-section">
                    
                    <div class="loan-header">
                        <h4>EMPRUNTS</h4>
                        <p>Je veux consulter les livres que j’ai empruntés</p>
                    </div>

                    <?php
                    
                    if (isset($_SESSION['email'])) { ?>

                        <div class="loan-body">
                            <h5>Livres empruntés :</h5>
                            <div class="cont-books cont-books-loaned">

                            <?php

                            if (empty($loaned_books)) {  ?>

                                <p class="no-loans-books">Vous n'avez pas encore emprunté de livres, <a href="search.php?all=on">visitez</a> la LivroThèque pour trouver votre bonheur !</p>
                                
                            <?php }
                            
                            foreach($loaned_books as $loaned_book) { ?>
                            <a href="book.php?id=<?= $loaned_book['ISBN'] ?>">
                                <img src='<?= $loaned_book['pic'] ?>' alt="picture of a book loaned">
                            </a>
                            <?php } ?>
                            
                            </div>
                        </div>
                        
                        <div class="loan-footer">
                            <a href="loanpage.php" class="btn-cta">Mes livres empruntés</a>
                        </div>


                    <?php } 
                
                    else { ?>

                        <div class="loan-body loan-body-unsubscribed">
                            <h4>Vous n'êtes pas connecté !</h4>
                            <p>
                                <a href="login.php">Connectez-vous</a> pour pouvoir emprunter des livres
                            </p>
                        </div>

                        <div class="loan-footer">
                            <a href="login.php" class="btn-cta">Connexion</a>
                        </div>

                    <?php  }  ?>
                    
                </div>
                <div class="discover-section">
                    
                    <div class="discover-header">
                        <h4>NOUVEAUTÉS</h4>
                        <p>Je veux découvrir de nouveaux livres</p>
                    </div>
                    
                    <div class="discover-body">
                        <h5>Livres bientôt ajoutés à  la LivroThèque :</h5>
                        <div class="cont-books cont-books-discovered">
                            <?php
                            $nb_books = 1;
                            foreach ($books as $book) {
                                
                                if ($nb_books != 3 && $book['release_date'] > date("Y-m-d")) { ?>

                                    <a href="book.php?id=<?= $book['ISBN'] ?>">
                                        <img src='<?= $book['pic'] ?>' alt="picture of the book">
                                    </a>
                                
                                <?php
                                    $nb_books += 1;
                                } 

                            } ?>
                        </div>
                    </div>
                    
                    <div class="discover-footer">
                        <a href="search.php?new-only=on" class="btn-cta">
                                Voir les nouveautés
                            </a>
                    </div>
                </div>
                

        </main>
        
        
    </div>
    
    <?php include "../components/footer.php" ?>
    <script src="../js/navbar.js"></script>
    
</body>
</html>