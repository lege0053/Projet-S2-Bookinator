<?php
declare(strict_types=1);

require_once "../autoload.php";
require_once "../src/Utils.php";
init_php_session();

$id='';
if(isset($_GET['isbn']) && !empty($_GET['isbn']) && ctype_digit($_GET['isbn']) && Livre::exist($_GET['isbn']) && isLogged())
    $id=$_GET['isbn'];
else
    header('Location: ../index.php');
try{
    $req=MyPDO::getInstance()->prepare(<<<SQL
    INSERT INTO Favoris(ISBN, idUtilisateur)
    VALUES(?, ?)
SQL);
    $req->execute([$id, $_SESSION['idUtilisateur']]);

    header('Location: ../Article.php?idArticle='.$id);
}catch (Exception $e){
    echo "<script>window.alert('Ce livre était déjà en favori ou une erreur interne est survenue.')</script>";
    echo "<script>window.location.href='../Article.php?idArticle=$id'</script>";
}