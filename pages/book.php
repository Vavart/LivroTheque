<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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

    include "../php/connectionSql.php";

    $isbn = $_REQUEST['id'];
    
    $query = "SELECT livre.ISBN, livre.subject, livre.title, livre.author, livre.editor, livre.release_date, livre.pic, livre.abstract, stock.total, stock.loaned FROM livre, stock WHERE (livre.ISBN = $isbn AND stock.ISBN = $isbn)";
    
    $result = $connect->query($query);
    
    $book = $result->fetch_all(MYSQLI_ASSOC);
    $book = $book[0];

    $connected = false;
    if (isset($_SESSION['email'])) {
        $connected = true;

        $id_membre = $_SESSION['id_membre'];

        // Récupération des livres empruntés
        $query = "SELECT livre.ISBN, livre.pic, livre.title, livre.author, reservations.loan_date, reservations.due_date FROM membre, reservations, livre WHERE (membre.id = '$id_membre' AND reservations.id_membre = membre.id AND livre.ISBN = reservations.ISBN AND reservations.currentlyLoaned = 1)";
        $result = $connect->query($query);

        $loaned_books = $result->fetch_all(MYSQLI_ASSOC); 

        // Comptage des livres empruntés

        $query = "SELECT COUNT(*) FROM reservations WHERE (id_membre = '$id_membre' AND reservations.currentlyLoaned = 1)";
        $result = $connect->query($query);

        $nbOfBooksLoaned = $result->fetch_all(MYSQLI_ASSOC);
        $nbOfBooksLoaned = $nbOfBooksLoaned[0]['COUNT(*)'];

        $categories_french = array(
            'self-help' => 'Développement Personnel',
            'finance' => 'Finances',
            'entrepreneurship' => 'Entrepreneuriat',
            'politics' => 'Politique'
        );

    }

    // Check if the book is available
    $available = true;
    if ($book['total'] == 0) {
        $available = false;
    }

    // Check if the book was loaned
    $is_loaned = "";
    if (isset($_REQUEST['loaned']) && $_REQUEST['loaned'] = 'true' ) {
        $is_loaned = true;
    }

    $categories_french = array(
        'self-help' => 'Développement Personnel',
        'finance' => 'Finances',
        'entrepreneurship' => 'Entrepreneuriat',
        'politics' => 'Politique'
    );

    ?>

    <title><?= $book['title']?> - <?=  $book['author'] ?></title>

</head>
<body>

    <div class="page">

        <?php include "../components/navbar.php" ?>


        <!-- Début modale emprunt -->
        <div class="loan-overlay"></div>
            <div class="loanpage-modal">
                <div class="inner-modal">
                    <h4>Êtes-vous sûr de vouloir emprunter ce livre ?</h4>
                    <p>Une fois emprunté vous avez jusqu'au 
                        <span class="due-date">
                        <?php
                                setlocale (LC_TIME, 'fr_FR.utf8','fra');    
                                $today_date = date_create(date("Y-m-j"));
                                $today_date = date_add($today_date,date_interval_create_from_date_string("30 days"));
                                $today_date = date_timestamp_get($today_date);
                                echo strftime("%d %B %G", $today_date);
                            ?></span> pour lire et rendre ce livre en bibliothèque.
                    </p>

                    <form action="../php/bookLoaned.php" method="POST">
                        <input type="hidden" name="book_isbn" value='<?= $isbn ?>'>
                        <button class="btn-cta">Emprunter</button>
                    </form>

                    <button class="close-modal">X</button>

                </div>
            </div>
            <!-- Fin modale emprunt -->

        <main class="book-showcase">
            
            <div class="preview">
                <img src='<?= htmlspecialchars_decode($book['pic']) ?>' alt="previsuel du livre à emprunter">
            </div>

            <div class="book-description">
                <div class="header">
                    <h1><?= htmlspecialchars_decode($book['title']) ?> - <?= htmlspecialchars_decode($book['author']) ?></h1>

                    <p class="edition">Editeur : <?= htmlspecialchars_decode($book['editor']) ?>
                    </p>
                    <p class="date"> Date de parution : 
                    <?php                    
                        setlocale (LC_TIME, 'fr_FR.utf8','fra');    
                        $date = date_create($book['release_date']);
                        $date = date_timestamp_get($date);
                        $date = utf8_decode(strftime("%d %B %G", $date));
                        echo str_replace("?", "é", $date);      
                    ?>
                    </p>

                    <p class="category"> Catégorie : 
                        <?= $categories_french[$book['subject']] ?>
                    </p>
                </div>

                <div class="body">
                    <h3>Résumé :</h3>
                    <p><?= htmlspecialchars_decode($book['abstract']) ?>
                        </p>
                </div>

                <div class="footer">
                    <p class="availability">
                        <span data-stock='<?= $book['total'] - $book['loaned'] ?>' class="yesstock">
                            ✔️ Disponible - 
                        </span>
                            <?= htmlspecialchars_decode($book['total'] - $book['loaned']) ?> livre(s)
                            
                    </p>
                   
                    <?php

                    if ($available) {
                    
                        if($connected) { 

                            $loaned = false;
                            
                            
                            foreach($loaned_books as $loaned_book) {
                                if($loaned_book['ISBN'] == $book['ISBN']) { 
                                    $loaned = true; ?>
                                    <p class="isloaned">Vous empruntez actuellement ce livre.</p>
                                    <p class="deadline">Date limite  de rendu : 
                                        <span class="date">

                                        <?php
                                            setlocale (LC_TIME, 'fr_FR.utf8','fra');    
                                            $date = date_create($loaned_book['due_date']);
                                            $date = date_timestamp_get($date);
                                            echo strftime("%d %B %G", $date);

                                        ?>

                                        </span></p>
                                <?php 
                                }
                            }

                            if (!$loaned && $nbOfBooksLoaned == 3) { ?>
                                <p class="too-much-books-loaned">Vous avez déjà emprunté 3 livres! Rendez-en un en bibliothèque pour pouvoir emprunter des livres à nouveau.</p>

                        <?php } elseif (!$loaned && !$is_loaned) { ?>

                                <button class="book-reservation">
                                    Emprunter
                                </button>

                                <?php }
                        } 

                        else { ?>

                            <p class="need-to-be-connected">Vous devez être connecté pour pouvoir emprunter un livre. <a href="login.php?book=<?= $book['ISBN'] ?>">Se connecter</a></p>


                        <?php } 
                        
                        if ($is_loaned) { ?>
                            <p class="book-loaned">
                            Livre emprunté avec succès ! Il vous attend en bibliothèque.<br>
                            <a href="loanpage.php">--> Voir mes livres empruntés</a>
                            </p>


                        <?php } elseif ($is_loaned != '' && $is_loaned == false) { ?>

                            <p class="book-loaned-fail">
                                Erreur dans le processus d'emprunt
                            </p>
                    <?php } 
                    
                    } ?>

                    
                    



                    

                    
                </div>
            </div>
        </main>


    </div>
        

    <?php include "../components/footer.php" ?>
    <script src="../js/navbar.js"></script>
    <script src="../js/book.js"></script>
    
</body>
</html>