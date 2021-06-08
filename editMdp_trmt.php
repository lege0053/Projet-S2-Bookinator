<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();

if(isset($_POST['mdp']) && !empty($_POST['mdp']) && isset($_POST['repeat_mdp']) && !empty($_POST['repeat_mdp']) && isset($_POST['oldMdp']) && !empty($_POST['oldMdp'])) {

    $oldMdp= htmlspecialchars($_POST['oldMdp']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $repeat_mdp = htmlspecialchars($_POST['repeat_mdp']);
    $user = Utilisateur::createFromId($_SESSION['idUtilisateur']);

    if(password_verify($oldMdp, $user->getMdp()))
    {
        if($mdp==$repeat_mdp)
        {
            $mdp = password_hash($mdp, PASSWORD_BCRYPT);
            $update = MyPDO::getInstance()->prepare(<<<SQL
                    UPDATE Utilisateur
                    SET mdp = :mdp
                    WHERE idUtilisateur = :idUtilisateur
                SQL);
            $update->execute([':mdp'=>$mdp, ':idUtilisateur'=>$_SESSION['idUtilisateur']]);
            header('Location: userpage.php');
        }else header('Location: editMdp.php?reg_err=sameMdp');
    }else header('Location: editMdp.php?reg_err=oldMdp');
}else header('Location: editMdp.php');

