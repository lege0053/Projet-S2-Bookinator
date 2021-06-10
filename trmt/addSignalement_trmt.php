<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";

init_php_session();

if(!isLogged())
    header('Location: index.php');

$isBookReport=false;
$isCommentReport=false;
$isCommandReport=false;

$id = '';
$url='';
if (isset($_POST['isbn']))
{
    $isBookReport=true;
    $id=$_POST['isbn'];
    $url="isbn=$id";
}
else if (isset($_POST['idCmd']))
{
    $isCommandReport=true;
    $id=$_POST['idCmd'];
    $url="idCmd=$id";
}
else if (isset($_POST['idApp']))
{
    $isCommentReport=true;
    $id=$_POST['idApp'];
    $url="idApp=$id";
}
try{
    $req=MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO Signalement(idSignalement, contenu, dateSig, idUtilisateur)
        VALUES(null, ?,SYSDATE(),?)
    SQL);
    $req->execute([$_POST['contenu'], $_SESSION['idUtilisateur']]);

    $lastSig=MyPDO::getInstance()->prepare(<<<SQL
        SELECT idSignalement
        FROM Signalement
        ORDER BY 1 DESC
    SQL);
    $lastSig->execute();
    $lastSig=$lastSig->fetchAll();
    $idSignalement=$lastSig[0]['idSignalement'];
    if($isBookReport)
    {
        $req2=MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO SignalementLivre(idSignalement, ISBN)
        VALUES(?,?)
    SQL);
        $req2->execute([$idSignalement, $id]);
    }

    else if($isCommentReport)
    {
        $req2=MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO SignalementAppreciation(idSignalement, idAppreciation)
        VALUES(?,?)
    SQL);
        $req2->execute([$idSignalement, $id]);
    }

    else if($isCommandReport)
    {
        $req2=MyPDO::getInstance()->prepare(<<<SQL
        INSERT INTO SignalementCommande(idSignalement, idCmd)
        VALUES(?,?)
    SQL);
        $req2->execute([$idSignalement, $id]);
    }
    header('Location: index.php');
}catch(Exception $e)
{
    header('Location: Article.php?idArticle='.$id);
}

