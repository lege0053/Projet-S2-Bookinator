<?php

declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";

init_php_session();

$Commande=Utilisateur::createFromId($_SESSION['idUtilisateur'])->getPanier();
$user=$Commande->getIdCmd();


$supPanier = MyPDO::getInstance()->prepare(<<<SQL
        Delete from Contenu where idCmd=?
    SQL);
$supPanier->execute([$user]);

$req2 = MyPDO::getInstance()->prepare(<<<SQL
            UPDATE Commande
            SET prixCmd=?
            WHERE idCmd=?
SQL);
$req2->execute([0, $user]);

header('Location: panier.php');

