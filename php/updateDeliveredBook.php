<?php

    include "../php/connectionSql.php";

    // Récupération des valeurs des champs
    $book_isbn = $_POST["book_isbn"];
    $adherentNumber = $_POST["adherentNumber"];

    $today_date = date_create(date("Y-m-j"));
    $today_date = date_format($today_date,"Y-m-j");

    // Utilisation des valeurs
    $query = "UPDATE reservations SET due_date='$today_date', currentlyLoaned = 0 WHERE (ISBN=$book_isbn AND id_membre = $adherentNumber)";
    $result = $connect->query($query);

    // Update le stock et en conséquence
    $query = "UPDATE `stock` SET loaned = loaned - 1 WHERE `ISBN` = '$book_isbn'";
    $result = $connect->query($query);

   

    header('Location: ../pages/adminpage.php?msg=bookDeliveredSuccess');
    exit();

?>


