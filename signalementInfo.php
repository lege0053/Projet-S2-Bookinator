<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();

$idSig='';
if(isset($_GET['idSignalement']) && !empty($_GET['idSignalement']) && ctype_digit($_GET['idSignalement'])) {
    $idSig=$_GET['idSignalement'];

    $webPage = new WebPage("Signalement - ".$idSig);
    $webPage->appendContent(getHeader());
    $webPage->appendCssUrl("src/style.css");

    $sign=Signalement::createFromId((int)$idSig);

    $type=Signalement::getTypeSig($idSig);
    $user=Utilisateur::createFromId((int)$sign->getIdUtilisateur());
    $reporter=$user->getPseudo();
    $userTel=$user->getTel();
    if($userTel==null){
        $userTel='Non renseigné';
    }

    $html = <<<HTML
<!-- Signalement sélectionne -->
    <div class="d-flex flex-column justify-content-center">
        <div class="d-flex font-size-36 dark-text main-color-background mt-5 mb-5 px-5 border-radius-5 align-self-center">Signalement n°{$idSig}</div>
        <div class="d-flex flex-column px-5 pb-5">
            <table class="table table-striped table-bordered table-dark">
                <tr>
                    <td class="main-text-color">Date</td>
                    <td class='white-text-color'>{$sign->getDateSig()}</td>
                </tr>
                <tr>
                    <td class="main-text-color">Type</td>
                    <td class='white-text-color'>$type</td>
                </tr>
                <tr>
                    <td class="main-text-color">Contenu</td>
                    <td class='white-text-color'>{$sign->getContenu()}</td>
                </tr>
            </table>
        </div>           
    </div>   
<!-- Information sur le reporter -->   
    <div class="d-flex flex-column justify-content-center">
        <div class="d-flex font-size-36 dark-text main-color-background mt-5 mb-5 px-5 border-radius-5 align-self-center">Informations Du Reporter</div>
        <div class="d-flex flex-column px-5 pb-5">
            <table class="table table-striped table-bordered table-dark">
                <thead class="main-text-color">
                    <tr>
                      <th scope="row">Pseudo</th>
                      <th scope="row">Nom</th>
                      <th scope="row">Prénom</th>
                      <th scope="row">E-Mail</th>
                      <th scope="row">Téléphone</th>
                    </tr>
                </thead>         
                <tbody>
                    <tr>         
                        <td>{$user->getPseudo()}</td>
                        <td>{$user->getNom()}</td>
                        <td>{$user->getPrenom()}</td>
                        <td>{$user->getMail()}</td>
                        <td>$userTel</td>
                    </tr>
                </tbody>
            </table>
        </div>            
    </div>      
    
    
HTML;

    $webPage->appendContent($html);
    $webPage->appendContent(getFooter());
    echo $webPage->toHTML();

}else {
    echo "<script>window.alert('Signalement indisponible !')</script>";
    echo "<script>window.location.href='signalementAdmin.php'</script>";
    }
