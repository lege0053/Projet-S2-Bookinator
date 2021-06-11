<?php
declare(strict_types=1);

require "../autoload.php";
require "../src/Utils.php";
init_php_session();

if(isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['repeat_mail']) && !empty($_POST['repeat_mail'])) {
    $mail = htmlspecialchars($_POST['mail']);
    $repeat_mail = htmlspecialchars($_POST['repeat_mail']);

    $check = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * FROM Utilisateur
        WHERE mail = ?
    SQL
    );
    $check->execute([$mail]);
    $data = $check->fetch();
    $row = $check->rowCount();

    if($row == 0)
    {
        if(strlen($mail) <= 60)
        {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                $update = MyPDO::getInstance()->prepare(<<<SQL
                    UPDATE Utilisateur
                    SET mail = :mail
                    WHERE idUtilisateur = :idUtilisateur
                SQL);
                $update->execute([':mail'=>$mail, ':idUtilisateur'=>$_SESSION['idUtilisateur']]);
                header('Location: ../userpage.php');
            } else header('Location: ../editMail.php?reg_err=mail');
        } else header('Location: ../editMail.php?reg_err=mail_lenght');
    } else header('Location: ../editMail.php?reg_err=already');
} else header('Location: ../editMail.php');