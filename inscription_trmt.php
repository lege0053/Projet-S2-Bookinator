<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";

init_php_session();

if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prnm']) && !empty($_POST['prnm'])
    && isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['repeat_mail']) && !empty($_POST['repeat_mail'])
    && isset($_POST['mdp']) && !empty($_POST['mdp']) && isset($_POST['repeat_mdp']) && !empty($_POST['repeat_mdp'])
    && isset($_POST['dateNais']) && !empty($_POST['dateNais']))
{
    $nom = htmlspecialchars($_POST['nom']);
    $prnm = htmlspecialchars($_POST['prnm']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $repeat_mail = htmlspecialchars($_POST['repeat_mail']);
    $repeat_mdp = htmlspecialchars($_POST['repeat_mdp']);
    $dateNais = htmlspecialchars($_POST['dateNais']);

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
                            'INSERT INTO Utilisateur(nom, prnm, mail, mdp, dateNais)
                            VALUES(?, ?, ?, ?, ?)');
                        
                        $insert->execute([$nom, $prnm, $mail, $mdp, $dateNais]);

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
    } else header('Location: inscription.php?reg_err=already');
} else header('Location: inscription.php');
