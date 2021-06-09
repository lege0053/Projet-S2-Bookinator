<?php


declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";

init_php_session();

if(isset($_GET['ISBN']) && !empty($_GET['ISBN'])){
    $isbn=$_GET['ISBN'];
}

$supPanier = MyPDO::getInstance()->prepare(<<<SQL
        Delete from Contenu where ISBN = ?
    SQL);
$supPanier->execute([$isbn]);

header('Location: panier.php');