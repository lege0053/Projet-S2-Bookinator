<?php
declare(strict_types=1);

require "../autoload.php";
require "../src/Utils.php";

init_php_session();

if(isset($_POST['ISBN']) && !empty($_POST['ISBN']))
{
    $update= MyPDO::getInstance()->prepare(<<<SQL
    UPDATE Livre
    SET qte = 0
    WHERE ISBN = :ISBN
SQL);

    $update->execute([':ISBN'=>$_POST['ISBN']]);
    header('Location: ../gestionLivre.php');
}else header('Location: ../gestionLivre.php?reg_err=ISBN');

