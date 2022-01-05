<?php

    include "../php/connectionSql.php";

    // Inputs vides ?
    if(!empty($_POST["booksToCommand"])) {

        // Récupération des valeurs des champs
        $booksToCommand = $_POST["booksToCommand"];
        $book_isbn = $_POST["book_isbn"];

        // Utilisation des valeurs
        $query = "UPDATE stock SET ordered=ordered+$booksToCommand WHERE stock.ISBN = $book_isbn";

        $result = $connect->query($query);
        header('Location: ../pages/adminpage.php?msg=commandSuccessful');
        exit();

    }
    else
        echo "Toutes les cases du formulaire ne sont pas remplies";
        header('Location: ../pages/adminpage.php');
        exit();
?>
