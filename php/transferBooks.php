<?php

    include "../php/connectionSql.php";

    // Récupération des valeurs des champs
    $book_isbn = $_POST["book_isbn"];

    // Utilisation des valeurs
    $query = "UPDATE stock SET total=total + ordered WHERE stock.ISBN = $book_isbn";
    $result = $connect->query($query);

    $query = "UPDATE stock SET ordered=0 WHERE stock.ISBN = $book_isbn";
    $result = $connect->query($query);

    header('Location: ../pages/adminpage.php?msg=addStockSuccessful');
    exit();

?>
