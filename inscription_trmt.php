<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";

if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prnm']) && !empty($_POST['prnm'])
&& isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['mdp']) && !empty($_POST['mdp']))
{
    $nom = htmlspecialchars($_POST['nom']);
    $prnm = htmlspecialchars($_POST['prnm']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = htmlspecialchars($_POST['mdp']);

    $check = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM Utilisateur
        WHERE mail = ?
    SQL);
    $check->execute([$mail]);
    $data = $check->fetch();
    $row = $check->rowCount();

    if($row == 0)
    {
        if(strlen($nom) <= 40)
        {
            if(strlen($prnm) <= 40)
            {
                if(strlen($mail) <= 60)
                {
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                    {
                        $mdp = password_hash($mdp, PASSWORD_BCRYPT);
                        
                        $insert = MyPDO::getInstance()->prepare(
                            'INSERT INTO Utilisateur(nom, prnm, mail, mdp)
                            VALUES(?, ?, ?, ?)');
                        
                        $insert->execute([$nom, $prnm, $mail, $mdp]);

                        $get = MyPDO::getInstance()->prepare(<<<SQL
                            SELECT * FROM Utilisateur
                            WHERE mail = ?
                        SQL);
                        $get->execute([$mail]);
                        $data = $get->fetch();

                        $_SESSION['idUtilisateur'] = (int)($data['idUtilisateur']);
                        $_SESSION['isAdmin'] = (int)($data['isAdmin']);
                        header('Location: userpage.php');

                    } else header('Location: inscription.php?reg_err=mail');
                } else header('Location: inscription.php?reg_err=mail_lenght');
            } else header('Location: inscription.php?reg_err=prnm_lenght');
        } else header('Location: inscription.php?reg_err=nom_lenght');
    } else echo header('Location: inscription.php?reg_err=already');
}
