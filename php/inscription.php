<?php
    session_start();
    include "../php/connectionSql.php";

    // Si l'on a cherché à se connecter
    if (isset($_POST['email']) && isset($_POST['password'])) {

        // Récupération des valeurs des champs
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
        $surname = htmlspecialchars($_POST['surname'], ENT_QUOTES);

        // Check if the email is associated with another account
        $query = "SELECT email FROM membre WHERE '$email'= email ";
        $result = $connect->query($query);
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        // If it's the case
        if ($rows) {
            header('Location: ../pages/signup.php?email=alreadyUsed');
            exit();
        }
    
        // Utilisation des valeurs
        // Count all users to increment the id
        $query = "SELECT COUNT(*) FROM membre";
        $result = $connect->query($query);
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $id = $rows[0]['COUNT(*)'] + 1;

        // Encoding the password to only save a hash in db
        $password_encoded = crypt($password, $password);

        // Adding member to database
        $query = "INSERT INTO membre (id, member_name, surname, email, psw, isAdmin) VALUES ('$id','$name','$surname','$email','$password_encoded',0)";
        $result = $connect->query($query);

        $_SESSION['id_membre'] = $id;
        $_SESSION['member_name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header('Location: ../pages/home.php');
        exit();
        
    }

?>