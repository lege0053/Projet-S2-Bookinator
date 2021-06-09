<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";
init_php_session();

$id='9782723488525';
if(isset($_GET['isbn']) && !empty($_GET['isbn']) && ctype_digit($_GET['isbn']))
    $id=$_GET['isbn'];

$req=MyPDO::getInstance()->prepare(<<<SQL
    INSERT INTO Favoris(ISBN, idUtilisateur)
    VALUES(?, ?)
SQL);
$req->execute([$id, $_SESSION['idUtilisateur'] ]);

header('Location: Article.php?idArticle='.$id);