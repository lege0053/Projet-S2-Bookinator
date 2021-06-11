<?php


declare(strict_types=1);

require "../autoload.php";
require "../src/Utils.php";

init_php_session();

$Commande=Utilisateur::createFromId($_SESSION['idUtilisateur'])->getPanier();
$user=$Commande->getIdCmd();

if(isset($_GET['ISBN']) && !empty($_GET['ISBN'])){
    $isbn=$_GET['ISBN'];
}

$req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT qte
                FROM Contenu 
                WHERE ISBN=?
                AND idCmd=?
    SQL);
$req->execute([$isbn,$user]);
$qte = $req->fetch();
$qte=(int)($qte['qte']);

if($qte > 1)
{
    $supQte = MyPDO::getInstance()->prepare(<<<SQL
                UPDATE Contenu
                SET qte = qte-1
                WHERE ISBN=?
                AND idCmd=?
    SQL);
    $supQte->execute([$isbn,$user]);

}
else{
    $supPanier = MyPDO::getInstance()->prepare(<<<SQL
        Delete from Contenu where ISBN = ? AND idCmd=?
    SQL);
    $supPanier->execute([$isbn,$user]);
}

//Nicø — Aujourd’hui à 17:49
$reqTest = MyPDO::getInstance()->prepare(<<<SQL
                SELECT SUM(liv.prix*ctn.qte) AS "prix"
                            FROM Contenu ctn INNER JOIN Livre liv ON liv.ISBN=ctn.ISBN
                            WHERE ctn.idCmd=?        
                SQL);
$reqTest->execute([$user]);
$prix = $reqTest->fetch();
if($prix['prix']==null)
    $prix = 0;
else
    $prix = $prix['prix'];
$req2 = MyPDO::getInstance()->prepare(<<<SQL
            UPDATE Commande
            SET prixCmd=?
            WHERE idCmd=?
SQL);
$req2->execute([$prix, $user]);


header('Location: ../panier.php');