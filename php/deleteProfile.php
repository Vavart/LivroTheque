<?php
    session_start();

    include "../php/connectionSql.php";

    // Récupération des valeurs des champs
    $membre_id = $_SESSION['id_membre'];



    // Vérification si la personne n'a pas de livres empruntés
    $query = "SELECT * FROM reservations WHERE id_membre=$membre_id";
    $result = $connect->query($query);
    $books = $result->fetch_all(MYSQLI_ASSOC);

    // If it's the case
    if ($books) {
        header('Location: ../pages/profile.php?msg=deleteFailed');
        exit();
    }
    

    // Delete history too
    $query = "DELETE FROM `reservations_history` WHERE `id_membre`=$membre_id";
    $result = $connect->query($query);

    // If it's not
    $query = "DELETE FROM `membre` WHERE `id`=$membre_id";
    $result = $connect->query($query);

    // On se déconnecte et nous sommes redirigés
    session_destroy();
    header('Location: ../pages/home.php');
    exit();

?>


