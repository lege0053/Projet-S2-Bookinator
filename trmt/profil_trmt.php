<?php
declare(strict_types=1);

require "../autoload.php";
require "../src/Utils.php";

init_php_session();

if(isset($_POST['nom']) && !empty($_POST['nom']) && isset($_POST['prnm']) && !empty($_POST['prnm'])
    && isset($_POST['ville']) && !empty($_POST['ville']) && isset($_POST['CP']) && !empty($_POST['CP']) && isset($_POST['adresse']) && !empty($_POST['adresse'])
    && isset($_POST['tel']) && !empty($_POST['tel']))
{

    $nom = htmlspecialchars($_POST['nom']);
    $prnm = htmlspecialchars($_POST['prnm']);
    $ville = htmlspecialchars($_POST['ville']);
    $CP = htmlspecialchars($_POST['CP']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $tel = htmlspecialchars($_POST['tel']);

    if(strlen($nom) <= 40)
    {
        if(strlen($prnm) <= 40)
        {
            if(strlen($ville) <= 38)
            {
                if(strlen($CP) == 5)
                {
                    if(strlen($adresse) <= 40)
                    {
                        if(strlen($tel) <= 10)
                        {
                            $update= MyPDO::getInstance()->prepare(<<<SQL
                                UPDATE Utilisateur
                                SET nom = :nom,
                                    prnm = :prnm,
                                    tel = :tel,
                                    ville = :ville,
                                    CP = :CP,
                                    rue = :rue
                                WHERE idUtilisateur = :idUtilisateur
                            SQL);
                            $update->execute([':nom'=>$nom,':prnm'=>$prnm,':tel'=>$tel,':ville'=>$ville,':CP'=>$CP, ':rue'=> $adresse,':idUtilisateur'=>$_SESSION['idUtilisateur']]);
                            header('Location: ../userpage.php');
                        }else header('Location: ../userpage.php?reg_err=tel_lenght');
                    }else header('Location: ../userpage.php?reg_err=adresse_lenght');
                }else header('Location: ../userpage.php?reg_err=CP_lenght');
            }else header('Location: ../userpage.php?reg_err=ville_lenght');
        } else header('Location: ../userpage.php?reg_err=prnm_lenght');
    } else header('Location: ../userpage.php?reg_err=nom_lenght');
} else header('Location: ../userpage.php');



