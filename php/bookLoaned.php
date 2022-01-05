<?php

    session_start();

    include "../php/connectionSql.php";

    // Inputs vides ?
    if(!empty($_POST["book_isbn"])) {

        // Récupération des valeurs des champs
        $book_isbn = $_POST["book_isbn"];
        $id_membre = $_SESSION['id_membre'];


        $query = "SELECT title, author FROM livre WHERE ISBN = $book_isbn";
        $result = $connect->query($query);
        $book = $result->fetch_all(MYSQLI_ASSOC);
        $book = $book[0];

        $book_title = htmlspecialchars($book['title'], ENT_QUOTES);
        $book_author = htmlspecialchars($book['author'], ENT_QUOTES);


        $due_date = date_create(date("Y-m-j"));
        $due_date = date_add($due_date,date_interval_create_from_date_string("30 days"));
        $due_date = date_format($due_date,"Y-m-j");
        
        $today_date = date_create(date("Y-m-j"));
        $today_date = date_format($today_date,"Y-m-j");
        
        // Utilisation des valeurs
        // Insertion dans les emprunts des clients
        $query = "INSERT INTO `reservations`(`ISBN`, `book_title`, `book_author`, `id_membre`, `loan_date`, `due_date`) VALUES ('$book_isbn','$book_title','$book_author','$id_membre','$today_date','$due_date')";
        $result = $connect->query($query);

        // Ajout d'un livre emprunté au stock
        $query = "UPDATE `stock` SET loaned = loaned + 1 WHERE ISBN = $book_isbn ";
        $result = $connect->query($query);

        // Ajout à l'historique des réservations
        $query = "INSERT INTO `reservations_history`(`ISBN`, `book_title`, `book_author`, `id_membre`, `loan_date`, `due_date`) VALUES ('$book_isbn','$book_title','$book_author','$id_membre','$today_date','NULL')";
        $result = $connect->query($query);

        $url = "../pages/book.php?id=$book_isbn&loaned=true";
        header("Location: $url");
        exit();

    } else {
        $url = "../pages/book.php?id=$book_isbn&loaned=false";
        header("Location: $url");
        exit();
    }
?>
