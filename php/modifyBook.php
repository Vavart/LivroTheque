<?php

    include "../php/connectionSql.php";

    // Récupération des valeurs des champs
    $isbn = $_POST["isbn"];
    $title = htmlspecialchars($_POST["bookTitle"], ENT_QUOTES);
    $author = htmlspecialchars($_POST["bookAuthor"], ENT_QUOTES);
    $editor = htmlspecialchars($_POST["bookEditor"], ENT_QUOTES);
    $date = $_POST["bookDate"];
    // $pic = htmlspecialchars($_POST["bookCover"], ENT_QUOTES);
    $abstract = htmlspecialchars($_POST["bookAbstract"], ENT_QUOTES);
    $keepPic = htmlspecialchars($_POST['keepPic'], ENT_QUOTES);

    if (isset($_POST['category'])) {
        $category = $_POST['category'];
    }

    else {
        header('Location: ../pages/adminpage.php?error=missField');
        exit();
    }

    // Image
    if (isset($_FILES['bookCover']) && $keepPic == 'false') {

        
        $uploadPath = '../assets/pictures/books/';
        $tmpFile = $_FILES["bookCover"]["tmp_name"];

        $uploadfile = $uploadPath . basename($_FILES['bookCover']['name']);
        
        $imageFileType = strtolower(pathinfo($uploadfile,PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

        $uploadOk = true;
    
        if(!in_array($imageFileType, $allowedTypes)) {
            $uploadOk = false;
            header('Location: ../pages/adminpage.php?error=imgFormatNotAllowed');
            exit();
        }
    
        if ($uploadOk) {
            if(move_uploaded_file($tmpFile, $uploadfile)) {

                $pic = $uploadfile;
                
                // Utilisation des valeurs
                $query = "UPDATE `livre` SET `ISBN`='$isbn',`title`='$title',`author`='$author',`subject`='$category',`editor`='$editor',`release_date`='$date',`pic`='$pic',`abstract`='$abstract' WHERE `ISBN`= $isbn";
                $result = $connect->query($query);

                header('Location: ../pages/adminpage.php');
                exit();
                
            }
        }
    } elseif ($keepPic == 'true') {

        // Utilisation des valeurs
        $query = "UPDATE `livre` SET `ISBN`='$isbn',`title`='$title',`author`='$author',`subject`='$category',`editor`='$editor',`release_date`='$date',`abstract`='$abstract' WHERE `ISBN`= $isbn";
        $result = $connect->query($query);

        header('Location: ../pages/adminpage.php?msg=modifySuccessful');
        exit();
    }

    header('Location: ../pages/adminpage.php?error=unknown');
    exit();

?>
