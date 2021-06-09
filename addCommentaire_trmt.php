<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";
init_php_session();

$id='9782723488525';
if(isset($_GET['isbn']) && !empty($_GET['isbn']) && ctype_digit($_GET['isbn']))
    $id=$_GET['isbn'];

$add = MyPDO::getInstance()->prepare(<<<SQL
        SElECT * FROM Appreciation
        WHERE ISBN= ?
        AND idUtilisateur=?
    SQL);
$add->execute([$id, $_SESSION['idUtilisateur']]);
$test=$add->fetch();
if(!$test)
{
    $req=MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO Appreciation(idAppreciation, commentaire, note, dateApp, idUtilisateur, ISBN)
        VALUES(null, ?,?,SYSDATE(),?,?)
    SQL);
    $req->execute([$_POST['commentaire'], $_POST['note'], $_SESSION['idUtilisateur'], $id]);
}
header('Location: Article.php?idArticle='.$id);
