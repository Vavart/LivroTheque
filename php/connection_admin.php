<?php
    session_start();
    include "../php/connectionSql.php";

    // Si l'on a cherché à se connecter
    if (isset($_POST['email']) && isset($_POST['password'])) {

        // Récupération des valeurs des champs
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Encoding the password and compare it with the hash in db
        $password_encoded = crypt($password, $password);

        // Utilisation des valeurs
        $query = "SELECT * FROM membre WHERE ('$email' = email AND '$password_encoded' = psw)";
    
        $result = $connect->query($query);
    
        // On regarde si l'on a bien une réponse
        $row = $result->fetch_all(MYSQLI_ASSOC);
        
    
        // Si ce n'est pas le cas la réponse est incorrect
        if (!$row) {
            header('Location: ../pages/login_admin.php?connection=fail');
            
        } else {

            $_SESSION['id_membre'] = $row[0]['id'];
            $_SESSION['member_name'] = $row[0]['member_name'];
            $_SESSION['surname'] = $row[0]['surname'];
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            
            header('Location: ../pages/adminpage.php');
            exit();
        }
    }

?>