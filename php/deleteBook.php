<?php

    include "../php/connectionSql.php";

    // Récupération des valeurs des champs
    $book_isbn = $_POST["book_isbn"];


    // Vérification si le livre en question est emprunté et / ou en cours de commande
    $query = "SELECT ordered, loaned FROM stock WHERE ISBN=$book_isbn";
    $result = $connect->query($query);
    $books = $result->fetch_all(MYSQLI_ASSOC);

    foreach($books as $property => $value) {
        if ($value['ordered'] != 0 || $value['loaned'] != 0) {
            $url = "../pages/adminpage.php?error=cannotDelete";
            header("Location: $url");
            exit();
        }
    }

    // Utilisation des valeurs
    $query = "DELETE FROM `livre` WHERE `ISBN`=$book_isbn";
    $result = $connect->query($query);

    $query = "DELETE FROM `stock` WHERE `ISBN`=$book_isbn";
    $result = $connect->query($query);

    header('Location: ../pages/adminpage.php?msg=deleteSuccessful');
    exit();

?>


