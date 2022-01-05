<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>

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

        if ((isset($_SESSION['email']) && $_SESSION['email'] != "Admin") || !isset($_SESSION['email'])) {
            $url = "login_admin.php";
            header("Location: $url");
            exit();
        }
    
        // Je me connecte
        include "../php/connectionSql.php";

        // Je pose mes queries
        $query = "SELECT * FROM livre, stock WHERE livre.ISBN = stock.ISBN";

        $query2 = "SELECT * FROM membre,reservations WHERE (reservations.id_membre = membre.id AND reservations.currentlyLoaned=1)";

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

        $result2 = $connect->query($query2);
        $members = $result2->fetch_all(MYSQLI_ASSOC);
        $i = 0;

        foreach($members as $member) {
            foreach($member as $propkey => $propvalue) {
                $members[$i][$propkey] = htmlspecialchars_decode($propvalue);
            }
            $i++;
        }

        $queryReservation = "SELECT * FROM reservations";
        $resultQueryReservation = $connect->query($queryReservation);
        $reservations = $resultQueryReservation->fetch_all(MYSQLI_ASSOC);


        // Si une erreur est survenue pendant l'une des opérations
        $notification = '';
        $notification_success = '';
        if (isset($_REQUEST['error'])) {
            if ($_REQUEST['error'] == 'missField') {
                $notification = "Tous les champs doivent être remplis, veuillez réessayer.";
            }

            elseif ($_REQUEST['error'] == 'isbnAlreadyUsed') {
                $notification = "L'ISBN saisi correspond déjà un livre existant, veuillez réessayer.";
            }

            elseif ($_REQUEST['error'] == 'cannotDelete') {
                $notification = "Le livre en question est emprunté et / ou possède une commande en cours.<br>Faites en sorte qu'il n'y ait pas de livre emprunté ou en cours de commande quand vous supprimez un livre de la base de données.";
            } elseif ($_REQUEST['error'] == 'imgFormatNotAllowed') {
                $notification = "Le format d'image choisi n'est pas pris en charge par la base de données. Veuillez nous en excuser.";

            } elseif ($_REQUEST['error'] == 'unknown') {
                $notification = "Erreur inconnue";
            }
        }

        if (isset($_REQUEST['msg'])) {
            if ($_REQUEST['msg'] == 'addSuccessful') {
                $notification_success = "Le livre a bien été ajouté à la base de données.";
            } elseif ($_REQUEST['msg'] == 'modifySuccessful') {
                $notification_success = "Le livre a bien été modifié dans la base de données.";
            } elseif ($_REQUEST['msg'] == 'deleteSuccessful') {
                $notification_success = "Le livre a bien été supprimé de la base de données.";
            } elseif ($_REQUEST['msg'] == 'commandSuccessful') {
                $notification_success = "La commande a bien été passée.";
            } elseif ($_REQUEST['msg'] == 'addStockSuccessful') {
                $notification_success = "La commande a bien été ajoutée au stock.";
            } elseif ($_REQUEST['msg'] == 'bookDeliveredSuccess') {
                $notification_success = 'Le livre a bien été rendu.';
            }
        }
        
    ?>
</head>
<body class="">

    <div class="page">

        <?php include "../components/navbar.php" ?>
        
        <div class="cont-titres">
            <h2 class="cat-active">Stocks</h2>
            <h2>Emprunts</h2>
        </div>
        <p class="notification"><?= $notification ?></p>
        <p class="notification notification--succes"><?= $notification_success ?></p>

        <hr>

        <!-- Indications ds actions -->

        <div class="explications-actions"> 
            <div class="indications-actions">
                <h4>Légende :</h4>
                <ul>
                    <li><button>&#43;</button> <span>Commander des exemplaires</span></li>
                    <li><button>&#10004;</button> <span>Ajouter les commandes reçues au stock</span></li>
                    <li><button>&#9998;</button> <span>Modifier la fiche d'un livre</span></li>
                    <li><button class="delete-book-info">&#10539;</button> <span>Supprimer un livre de la base de données</span></li>
                    <li><span class="advice">Conseil</span> &#187; Cliquez sur un utilisateur pour rendre un livre ou lui envoyer un rappel (pour les emprunts).</li>
                </ul>                      
            </div>

            <!-- Actualiser -->
    
            <div class="refresh-page">
                <a href="adminpage.php">Actualiser la page</a>
            </div>

        </div>

        <hr>

        <main class="admin">

            <div class="admin-stock-overlay"></div>
            <!-- Début Modale "commander" -->    
            <div class="stock-modal command-more-book-modal">
                <div class="inner-modal">
                    <h3>Combien voulez-vous en commander ?</h3>

                    <form action="../php/commandMoreBooks.php" method="POST">
                        <div class="field">
                            <input type="number" name="booksToCommand" id="booksToCommand" min="1">
                            <input type="text" name="book_isbn" id="book_isbn">
                        </div>

                        <button type="submit">Commander</button>
                    </form>

                    <button class="close-stock-modal">
                        X
                    </button>

                </div>
            </div>     
            <!-- Fin Modale "commander" -->

            <!-- Début Modale "supprimer" -->       
            <div class="stock-modal delete-modal">
                <div class="inner-modal">
                    <h3>Êtes-vous sûr(e) de
                        supprimer ce livre de
                        la base de données ?</h3>
                    <p>Il pourra toujours être ajouté plus tard</p>

                    <form action="../php/deleteBook.php" method="POST">
                        <input type="text" name="book_isbn" id="book_isbn">
                        <button type="submit">Supprimer le livre</button>
                    </form>

                    <button class="close-stock-modal">
                        X
                    </button>

                </div>
            </div>       
            <!-- Fin Modale "supprimer" -->

            <!-- Début Modale "transférer" -->
            <div class="stock-modal transfer-modal">
                <div class="inner-modal">
                    <h3>Voulez-vous ajouter les commandes au stock ?</h3>
                    <p>Ne faites cela que si vous êtes sûr d'avoir reçu la commande</p>

                    <form action="../php/transferBooks.php" method="POST">
                        <input type="text" name="book_isbn" id="book_isbn">
                        <button type="submit">Ajouter au stock</button>
                    </form>

                    <button class="close-stock-modal">
                        X
                    </button>

                </div>
            </div>       
            <!-- Fin Modale "transférer" -->

            <!-- Début Modale "ajouter" -->
            <div class="stock-modal add-modal">
                <div class="inner-modal">
                    <h3>Ajouter un nouveau livre à la base de données : </h3>

                    <form action="../php/addBook.php" method="POST" enctype="multipart/form-data">
                        <div class="field-left">
                            <div class="field">
                                <label for="isbn">ISBN* :</label>
                                <input type="number" name="isbn" id="isbn" placeholder="ISBN" required>
                            </div>
                            <div class="field">
                                <label for="bookTitle">Titre* :</label>
                                <input type="text" name="bookTitle" id="bookTitle" placeholder="Titre" required>
                            </div>
                            <div class="field">
                                <label for="bookAuthor">Auteur* :</label>
                                <input type="text" name="bookAuthor" id="bookAuthor" placeholder="Auteur" required>
                            </div>
                            <div class="field">
                                <label for="bookEditor">Éditeur* :</label>
                                <input type="text" name="bookEditor" id="bookEditor" placeholder="Éditeur" required>
                            </div>
                            <div class="field">
                                <label for="bookDate">Date de parution* :</label>
                                <p class="date-indication">Cliquez sur le calendrier</p>
                                <input type="date" name="bookDate" id="bookDate" placeholder="Date de parution" required>
                            </div>
                        </div>
        
                        <div class="field-right">
                            <div class="field">
                                <label for="bookCover">Image de couverture* :</label>
                                <input type="file" name="bookCover" id="bookCover" placeholder="Image de couverture" required>
                            </div>

                            <div class="field">
                                <label for="bookCategory">Catégorie* :</label>

                                <div class="field">

                                    <div class="category">
                                        <label for="self-help">Développement Personnel</label>
                                        <input type="radio" name="category" id="self-help" value="self-help">
                                    </div>
                                    

                                    <div class="category">
                                        <label for="finance">Finances</label>
                                        <input type="radio" name="category" id="finance" value="finance">
                                    </div>
                                    
                                    <div class="category">
                                        <label for="entrepreneurship">Entrepreneuriat </label>
                                        <input type="radio" name="category" id="entrepreneurship" value="entrepreneurship">
                                    </div>
                                    
                                    <div class="category">
                                        <label for="politics">Politique</label>
                                        <input type="radio" name="category" id="politics" value="politics">
                                    </div>
                                </div>
                            </div>
        
                            <div class="field">
                                <label for="bookAbstract">Résumé* :</label>
                                <textarea name="bookAbstract" id="bookAbstract"required> </textarea>
                            </div>
                        </div>

                        <button type="submit">Ajouter le livre</button>
                    </form>

                    <button class="close-stock-modal">
                        X
                    </button>

                </div>
            </div>       
            <!-- Fin Modale "ajouter" -->

            <!-- Début Modale "modifier" -->
            <div class="stock-modal modify-modal">
                <div class="inner-modal">
                    <h3>Modifier un livre</h3>
                    <p>Les champs avec un * sont obligatoires</p>

                    <form action="../php/modifyBook.php" method="POST" enctype="multipart/form-data">
                        <div class="field-left">
                            <div class="field">
                                <label for="isbn">ISBN (non modifiable) :</label>
                                <input type="number" name="isbn" id="isbn" placeholder="ISBN" required readonly class="readonly-input">
                                
                            </div>
                            <div class="field">
                                <label for="bookTitle">Titre* :</label>
                                <input type="text" name="bookTitle" id="bookTitle" placeholder="Titre" required>
                            </div>
                            <div class="field">
                                <label for="bookAuthor">Auteur* :</label>
                                <input type="text" name="bookAuthor" id="bookAuthor" placeholder="Auteur" required>
                            </div>
                            <div class="field">
                                <label for="bookEditor">Éditeur* :</label>
                                <input type="text" name="bookEditor" id="bookEditor" placeholder="Éditeur" required>
                            </div>
                            <div class="field">
                                <label for="bookDate">Date de parution* :</label>
                                <p class="date-indication">Cliquez sur le calendrier</p>
                                <input type="date" name="bookDate" id="bookDate" placeholder="Date de parution" required>
                            </div>
                        </div>
        
                        <div class="field-right">
                            <div class="field">
                                <label for="bookCover">Image de couverture* : <span class="current-book-cover"></span></label>
                                <input type="file" name="bookCover" id="bookCover" placeholder="Image de couverture">
                                <input type="hidden" name="keepPic" id="keepPic">
                            </div>

                            <div class="field">
                                <label for="bookCategory">Catégorie* :</label>

                                <div class="field">

                                    <div class="category">
                                        <label for="self-help">Développement Personnel</label>
                                        <input type="radio" name="category" id="self-help" value="self-help">
                                    </div>
                                    

                                    <div class="category">
                                        <label for="finance">Finances</label>
                                        <input type="radio" name="category" id="finance" value="finance">
                                    </div>
                                    
                                    <div class="category">
                                        <label for="entrepreneurship">Entrepreneuriat </label>
                                        <input type="radio" name="category" id="entrepreneurship" value="entrepreneurship">
                                    </div>
                                    
                                    <div class="category">
                                        <label for="politics">Politique</label>
                                        <input type="radio" name="category" id="politics" value="politics">
                                    </div>
                                </div>
                                    
                            </div>
        
                            <div class="field">
                                <label for="bookAbstract">Résumé / Description* :</label>
                                <textarea name="bookAbstract" id="bookAbstract"required> </textarea>
                            </div>
                        </div>

                        <button type="submit">Sauvgarder les modifications</button>
                    </form>

                    <button class="close-stock-modal">
                        X
                    </button>

                </div>
            </div>       
            <!-- Fin Modale "modifier" -->
            
            <div class="cont-search-addbook">

                <div class="search-bar">
                    <img src="../assets/pictures/search.svg" alt="search icon">
                    <input type="text" placeholder="Recherche...">
                </div>

                <div class="addbook">
                    <button title="Ajouter un nouveau livre à la base de données" class="add-new-book">
                        Commander un nouveau livre
                    </button>
                </div>
                
            </div>
            
            <div class="table-cont-btn-actions">              
                <table class="table-loanpage table-admin">
                    <thead>
                        <tr>
                            <td>ISBN</td>
                            <td>Titre</td>
                            <td>Auteur</td>
                            <td>En stock</td>
                            <td>Commandés</td>
                            <td>Empruntés</td>
                            <td>Actions</td>
                        </tr>
                    </thead>

                    <?php
                        foreach ($books as $book) {
                        ?>
                        <tr class="trb stock">
                            <td data-label="ISBN"> <?= $book['ISBN'] ?> </td>
                            <td data-label="Titre"><?= htmlspecialchars_decode($book["title"]) ?></td>
                            <td data-label="Auteur"><?= htmlspecialchars_decode($book["author"]) ?></td>
                            <td data-label="En stock"><?= $book["total"] - $book['loaned']?></td>
                            <td data-label="Commandés"><?= $book["ordered"] ?></td>
                            <td data-label="Empruntés"><?= $book['loaned'] ?></td>

                            <td>
                                <div class="cont-btn-actions">
                                    <button title="Commander d'autres exemplaires de <?= htmlspecialchars_decode($book['title']) ?>" class="commandBook" data-book=<?= $book["ISBN"] ?>>
                                        <span>&#43;</span>
                                    </button>
                                        
                                    <button title="Supprimer <?= htmlspecialchars_decode($book['title'] )?> de la base de données" class="deleteBook" data-book=<?= ($book["ISBN"]) ?>>
                                    <span>&#10539;</span>
                                    </button>
                                    <button title="Ajouter les commandes reçues au stock" class="validateBook" data-book=<?= $book["ISBN"] ?>>
                                    <span>&#10004;</span> 
                                    </button>
                                    <button title="Modifier la fiche livre de <?= htmlspecialchars_decode($book['title']) ?>" class="modifyBook" 
                                    data-book='<?= htmlspecialchars(json_encode($book),ENT_QUOTES) ?>'>
                                        <span>&#9998;</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <?php } ?>
                </table>

                
            </div>
        </main>

        <main class="loans">

            <!-- Début Modale -->
            
            <div class="admin-overlay"></div>
            <div class="user-info-modal">
                <div class="cont-modal">
                    <h3>Détails de l'utilisateur</h3>

                    <form  method="POST" action="../php/updateDeliveredBook.php">
                        <div class="field">
                            <label for="adherentNumber">N° adhérent :</label>
                            <input type="text" name="adherentNumber" id="adherentNumber" readonly>
                        </div>

                        <div class="field">
                            <label for="name">Prénom :</label>
                            <input type="text" name="name" id="name" readonly>
                            <input type="hidden" name="book_isbn" id="book_isbn">
                            
                        </div>
                        <div class="field">
                            <label for="surname">Nom :</label>
                            <input type="text" name="surname" id="surname" readonly>
                        </div>
                        <div class="field">
                            <label for="email">Email :</label>
                            <input type="text" name="email" id="email" readonly>
                        </div>
                        <div class="field">
                            <label for="book_title">Titre emprunté :</label>
                            <input type="text" name="book_title" id="book_title" readonly>
                        </div>
                        <div class="field">
                            <label for="book_author">Auteur :</label>
                            <input type="text" name="book_author" id="book_author" readonly>
                        </div>
                        
        
                        <div class="cont-btns">
                            <button type="button" id="warningBtn">
                                Envoyer un rappel
                            </button>
                            <button type="submit">
                                Livre rendu
                            </button>
                        </div>
                    </form>

                    <button class="close-modal">
                        X
                    </button>
                </div>
            </div>
            
            <!-- Fin Modale -->

            <div class="cont-search-addbook">

                <div class="search-bar">
                    <img src="../assets/pictures/search.svg" alt="search icon">
                    <input type="text" placeholder="Recherche...">
                </div>

                <div class="addbook">
                    <h4>Date du jour : <span><?= date("d / m / Y") ?></span></h4>
                </div>
                
            </div>
            

            <div class="table-cont-btn-actions">
                
                <table class="table-loanpage">
                    <thead>
                        <tr>
                            <td>Nom / Prénom</td>
                            <td>Titre</td>
                            <td>Auteur</td>
                            <td>Date d'emprunt</td>
                            <td>À rendre avant le...</td>
                        </tr>
                    </thead>

                    <?php
                        foreach ($members as $member) {
                        ?>
                    
                        <tr class="trb loans" data-book='<?= htmlspecialchars(json_encode($member),ENT_QUOTES) ?>'>
                            <td data-label="Nom / Prénom">
                                <?= $member["surname"] ?>
                                <?= ' / ' ?>
                                <?= $member["member_name"] ?>
                            </td>
                            <td data-label="Titre">
                                <?= $member["book_title"] ?>
                            </td>
                            <td data-label="Auteur">
                                <?= $member["book_author"] ?>
                            </td>
                            <td data-label="Date d'emprunt">
                            <?php 
                                $date=date_create($member['loan_date']);
                                echo date_format($date,"d / m / Y");                         
                            ?>
                            </td>
                            <td data-label="À rendre avant le...">
                            <?php                        
                                $date=date_create($member['due_date']);
                                echo date_format($date,"d / m / Y");                       
                            ?>
                            </td>
                        </tr>

                    <?php } ?>

                    
                </table>
            </div>
        </main>

    </div>
        

    <?php include "../components/footer.php" ?>
    <script src="../js/navbar.js"></script>
    <script src="../js/adminpage.js"></script>
    
</body>
</html>