<?php
session_start();

$isbn = $_POST["isbn"];

$url = ("../pages/book.php?id=$isbn");

?> <pre><?php var_export($url); ?></pre> <?php 
// die();


header("Location: $url");
exit();
?>