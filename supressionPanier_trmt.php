<?php


declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";

init_php_session();

if(isset($_GET['ISBN']) && !empty($_GET['ISBN'])){
    $isbn=$_GET['ISBN'];
}

$req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT qte
                FROM Contenu 
                WHERE ISBN=?
    SQL);
$req->execute([$isbn]);
$qte = $req->fetch();
$qte=(int)($qte['qte']);

if($qte > 1)
{
    $supQte = MyPDO::getInstance()->prepare(<<<SQL
                UPDATE Contenu
                SET qte = qte-1
                WHERE ISBN=?
    SQL);
    $supQte->execute([$isbn]);

}
else{
    $supPanier = MyPDO::getInstance()->prepare(<<<SQL
        Delete from Contenu where ISBN = ?
    SQL);
    $supPanier->execute([$isbn]);
}





header('Location: panier.php');