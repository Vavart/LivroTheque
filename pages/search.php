<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Balises Meta -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>

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
    }

    // Je pose mes queries
    $query = "SELECT * FROM livre, stock WHERE livre.ISBN = stock.ISBN ORDER BY livre.subject DESC";

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

    $categories = array(
        'all' => 'on'
    );
    // On récupère la requête de l'url si l'utilisateur a formulé des critères plus spécifiques
    if (!empty($_REQUEST)) {
        $categories = $_REQUEST;
    }
    
    $categories_french = array(
        'self-help' => 'Développement Personnel',
        'finance' => 'Finances',
        'entrepreneurship' => 'Entrepreneuriat',
        'politics' => 'Politique'
    );
    
    
    ?>

</head>
<body>

    <div class="page">

        <?php include "../components/navbar.php" ?>
        
        <div class="connection-info">

            <?php 
            
            if ($member_name == "") { ?>
                <p><span>Navigation en tant qu'invité !</span><br> <a href="login.php">Connectez-vous</a> pour bénéficier de toutes les fonctionnalités de la LivroThèque</p>
           <?php } 

           else { ?>
               <p><span>Dites-nous <?= $member_name ?> !</span><br> Quel livre vous plaît ?</p>
           <?php } ?>

        </div>
        
        
        <main class="main-grid">
            
            <div class="search-fields">
                <h3>Critères de recherche</h3>

                <form action="" method="GET" class="search-criterias">

                    <div class="criteria">

                        <h4>Type : </h4>
                        <div class="cont-labels">

                            <div class="cont-label">
                                <label for="all">Tout</label>
                                <input type="checkbox" name="all" id="all">
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

            <div class="search-bar search-search-bar">
                <img src="../assets/pictures/search.svg" alt="search icon" class="search-icon">
                <input type="text" placeholder="Recherche ..." id="search-bar">
            </div>

            
            <div class="searching-content">
                
            <?php
            foreach($books as $book) { ?>                         
                <div class="searched-item" data-category='<?= $book['subject'] ?>' data-disponibility='<?= $book['total'] - $book['loaned']?>' data-date='<?= $book['release_date'] > date("Y-m-d")?>'>
                    <div class="preview">
                        <img src=<?= htmlspecialchars_decode($book['pic']) ?> alt="preview of the book searched">
                    </div>
                    
                    <div class="description">
                        <h6><?= htmlspecialchars_decode($book['title']) ?></h6>
                        <p class="autor"><?= htmlspecialchars_decode($book['author']) ?></p>
                        <p class="edition">
                        <span class="category">
                        <?= $categories_french[$book['subject']]; ?>
                        </span> - 
                            
                        <?= htmlspecialchars_decode($book['editor']) ?></p>
                        
                        <p class="availability">

                        <?php 
                            if ($book['total'] - $book['loaned'] == 0) { ?>
                                <span class="nostock">❌ Indisponible -  </span>

                            <?php } else { ?>
                                <span class="yesstock">✔️ Disponible - </span>

                        <?php } ?>

                            <?= ($book['total'] - $book['loaned']) ?> livre(s)
                        </p>
                    </div>
                    
                    <div class="btn-view-book">
                    <a type="submit" href="book.php?id=<?= $book['ISBN'] ?>" id="btnViewBook">
                        Voir la fiche
                    </a>
                    </div>
                    
                </div>
            <?php } ?>
            </div>  
        </main>
        
        
    </div>
    
    <?php include "../components/footer.php" ?>
    <script src="../js/navbar.js"></script>
    <script src="../js/search.js"></script>
    
</body>
</html>