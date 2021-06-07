<?php
declare(strict_types=1);

$couverture = $_POST['couverture'];
$isbn = $_POST['isbn'];
$titre = $_POST['titre'];
$prix = $_POST['prix'];
$editeur = $_POST['editeur'];
$auteur = $_POST['auteur'];
$datePublication = $_POST['datePublication'];
$genre = $_POST['genre'];
$langue = $_POST['langue'];
$description = $_POST['description'];

MyPDO::






header('Location: addBook.php');