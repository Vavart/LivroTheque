<?php
    session_start();

    include "../php/connectionSql.php";

    // Récupération des valeurs des champs
    $email = $_POST['email'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $surname = $_POST['surname'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $id_membre = $_SESSION['id_membre'];    

    if ($oldPassword != $_SESSION['password']) {
        $url = "../pages/profile.php?modify=true&msg=noMatch";
        header("Location: $url");
        exit();
    }

    if ($_POST['newPassword'] == '') {

        $query = "UPDATE `membre` SET `member_name`='$name',`surname`='$surname',`email`='$email' WHERE id = $id_membre";
        $result = $connect->query($query);
    
    
        // Updating session 
        $_SESSION['member_name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['email'] = $email; 


    } else {
        $password_encoded = crypt($newPassword, $newPassword);
    
        $query = "UPDATE `membre` SET `member_name`='$name',`surname`='$surname',`email`='$email',`psw`='$password_encoded' WHERE id = $id_membre";
        $result = $connect->query($query);
    
    
        // Updating session 
        $_SESSION['member_name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $newPassword;  
    }
    header('Location: ../pages/profile.php?msg=success');
    exit();

?>


