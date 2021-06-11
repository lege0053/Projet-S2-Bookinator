<?php
declare(strict_types=1);

require_once "../autoload.php";
require_once "../src/Utils.php";
init_php_session();

$id='';
if(isset($_POST['isbn']) && !empty($_POST['isbn']) && ctype_digit($_POST['isbn']) && isLogged())
    $id=$_POST['isbn'];
else
    header('Location: ../index.php');
try{
    if(!Appreciation::exist($id, $_SESSION['idUtilisateur']))
    {
        $req=MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO Appreciation(idAppreciation, commentaire, note, dateApp, idUtilisateur, ISBN)
        VALUES(null, ?,?,SYSDATE(),?,?)
    SQL);
        $req->execute([$_POST['commentaire'], $_POST['note'], $_SESSION['idUtilisateur'], $id]);
        header('Location: ../Article.php?idArticle='.$id);
    }
    else
    {
        echo "<script>window.alert('Vous avez déjà rédigé un commentaire pour ce livre.')</script>";
        echo "<script>window.location.href='../Article.php?idArticle=$id'</script>";
    }
}catch(Exception $e){
    header('Location: ../Article.php?idArticle='.$id);
}

