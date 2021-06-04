<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();

if(isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['mdp']) && !empty($_POST['mdp']))
{
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = htmlspecialchars($_POST['mdp']);

    $check = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM Utilisateur
        WHERE mail = ?
    SQL);
    $check->execute([$mail]);
    $data = $check->fetch();
    $row = $check->rowCount();

    if($row == 1){
        if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
            if(password_verify($mdp, $data['mdp'])){

                $_SESSION['idUtilisateur'] = (int)($data['idUtilisateur']);
                $_SESSION['isAdmin'] = (int)($data['isAdmin']);
                header('Location:userpage.php');

            }
            else header('Location: connexion.php?login_err=password');
        }
        else header('Location: connexion.php?login_err=email');
    }
    else header('Location: connexion.php?login_err=inconnu');
}
else header('Location: connexion.php');