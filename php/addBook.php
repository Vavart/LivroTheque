<?php

    include "../php/connectionSql.php";

    // Récupération des valeurs des champs
    $isbn = $_POST["isbn"];
    $title = htmlspecialchars($_POST["bookTitle"], ENT_QUOTES);
    $author = htmlspecialchars($_POST["bookAuthor"], ENT_QUOTES);
    $editor = htmlspecialchars($_POST["bookEditor"], ENT_QUOTES);
    $date = utf8_encode($_POST["bookDate"]);
    // $pic = htmlspecialchars($_POST["bookCover"], ENT_QUOTES);
    $abstract = htmlspecialchars($_POST["bookAbstract"], ENT_QUOTES);

    $today_date = date_create();
    $today_date = date_timestamp_get($today_date);
    $today_date = date("Y-d-m h:i:s", $today_date);

    $category = $_POST['category'];

    // Check if the isbn is already used
    $query = "SELECT ISBN from livre";
    $result = $connect->query($query);
    $all_isbn = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($all_isbn as $b_isbn => $isbn_value) {

        if ($isbn_value['ISBN'] == $isbn) {
            header('Location: ../pages/adminpage.php?error=isbnAlreadyUsed');
            exit();
        }
    }

    if (!isset($_POST['category'])) {
        header('Location: ../pages/adminpage.php?error=missField');
        exit();
    }

  


    // Image
    if (isset($_FILES['bookCover'])) {
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
                $query1 = "INSERT INTO `livre` (`ISBN`, `title`, `author`, `subject`, `editor`, `release_date`, `pic`, `abstract`, `add_date`) VALUES ('$isbn', '$title', '$author','$category', '$editor', '$date', '$pic', '$abstract', '$today_date')";
                $result1 = $connect->query($query1);

                $query2 = "INSERT INTO stock (`ISBN`, `total`, `ordered`, `loaned`) VALUES ($isbn, 0, 0, 0)";
                $result2 = $connect->query($query2);

                header('Location: ../pages/adminpage.php?msg=addSuccessful');
                exit();
                
            }
        }
    }

    header('Location: ../pages/adminpage.php?error=unknown');
    exit();
    

?>
