<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes emprunts</title>

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

    if (isset($_SESSION['email'])) {
        $id_membre = $_SESSION['id_membre'];
        
        // Récupération des livres empruntés + historique
        $query = "SELECT livre.ISBN, livre.pic, livre.title, livre.author, reservations.loan_date, reservations.due_date, reservations.currentlyLoaned FROM membre, reservations, livre WHERE (membre.id = '$id_membre' AND reservations.id_membre = membre.id AND livre.ISBN = reservations.ISBN) ORDER BY reservations.due_date DESC";
        $result = $connect->query($query);
        $loaned_books = $result->fetch_all(MYSQLI_ASSOC);


        // Récupération de l'historique des livres empruntés
        // Récupération des livres empruntés
        // $query = "SELECT livre.ISBN, livre.pic, livre.title, livre.author, reservations.loan_date, reservations.due_date FROM membre, reservations, livre WHERE (membre.id = '$id_membre' AND reservations.id_membre = membre.id AND livre.ISBN = reservations.ISBN) ORDER BY reservations.due_date ASC";
        // $result = $connect->query($query);
        // $loaned_books_history = $result->fetch_all(MYSQLI_ASSOC);
    }
    
    ?>
</head>
<body>

    <div class="page">

        <?php include "../components/navbar.php" ?>

        <div class="cont-titres">
            <h2 class="cat-active">Emprunts</h2>
            <h2>Historique</h2>
        </div>

        <p class="indication">
            Conseil de pro : cliquez sur le livre en question pour accèder à ses caractérisques !
        </p>
        <hr class="sep-loan-title">

        <main class="loanpage-section">
            <table class="table-loanpage">
                <thead>
                    <tr>
                        <td>Aperçu</td>
                        <td>Titre</td>
                        <td>Auteur</td>
                        <td>Date d'emprunt</td>
                        <td>À rendre avant le...</td>
                    </tr>
                </thead>


                <?php foreach($loaned_books as $loaned_book) { 
                    
                    if ($loaned_book['currentlyLoaned']) { ?>
                  
                        <tr class="trb" data-book='<?= $loaned_book['ISBN'] ?>'>
                            <td data-label="Aperçu">
                                <img src='<?= $loaned_book['pic'] ?>' alt="preview of the loaned book">
                            </td>
                            <td data-label="Titre"><?= $loaned_book['title'] ?></td>
                            <td data-label="Auteur"><?= $loaned_book['author'] ?></td>
                            <td data-label="Date d'emprunt">
                                
                                <?php                        
                                    $date=date_create($loaned_book['loan_date']);
                                    echo date_format($date,"d / m / Y");                       
                                ?>
                        
                            </td>
                            <td data-label="À rendre avant le...">
                            <?php                        
                                    $date=date_create($loaned_book['due_date']);
                                    echo date_format($date,"d / m / Y");                       
                                ?>
                            </td>
                        </tr>
                        
                    <?php }
                } ?>

            </table>


        </main>

        <main class="history-section">

            <table class="table-loanpage">
                <thead>
                    <tr>
                        <td>Aperçu</td>
                        <td>Titre</td>
                        <td>Auteur</td>
                        <td>Date d'emprunt</td>
                        <td>Rendu le</td>
                    </tr>
                </thead>

                <?php foreach($loaned_books as $loaned_book) { ?>
                    

                    <tr class="trb" data-book='<?= $loaned_book['ISBN'] ?>'>
                        <td data-label="Aperçu">
                            <img src='<?= $loaned_book['pic'] ?>' alt="preview of the loaned book">
                        </td>
                        <td data-label="Titre"><?= $loaned_book['title'] ?></td>
                        <td data-label="Auteur"><?= $loaned_book['author'] ?></td>
                        <td data-label="Date d'emprunt">
                            
                            <?php                        
                                $date=date_create($loaned_book['loan_date']);
                                echo date_format($date,"d / m / Y");                       
                            ?>
                    
                        </td>
                        <td data-label="Rendu le">
                        <?php                        

                                $isLoaned = $loaned_book['currentlyLoaned'];

                                if ($isLoaned) {
                                    echo "Non rendu";
                                } else {
                                    echo date_format($date,"d / m / Y");                       
                                }
                            ?>
                        </td>
                    </tr>

                <?php } ?>

            </table>


        </main>


    </div>
        

    <?php include "../components/footer.php" ?>

    <script src="../js/navbar.js"></script>
    <script src="../js/loanpage.js"></script>
    
</body>
</html>