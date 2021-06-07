<?php
declare(strict_types=1);

function affichageLivre(string $isbn):string
{
    $livre=Livre::createFromId($isbn);

    $listeAuteur=$livre->getAuteurs();

    $nomsAuteurs='';
    for($i=0; $i<count($listeAuteur);$i++)
    {
        $nomsAuteurs.="<a href='' class='booki-link'>{$listeAuteur[$i]->getNom()} {$listeAuteur[$i]->getPrnm()}</a>";
        if($i!=count($listeAuteur)-1 && count($listeAuteur)!=1)
            $nomsAuteurs.=", ";
    }

    $listeGenre=$livre->getGenres();

    $nomsGenres='';
    for($i=0; $i<count($listeGenre);$i++)
    {
        $nomsGenres.="<a href='' class='booki-link'>{$listeGenre[$i]->getLibGenre()}</a>";
        if($i!=count($listeGenre)-1 && count($listeGenre)!=1)
            $nomsGenres.=", ";
    }

    $editeur=Editeur::createFromId($livre->getIdEditeur())->getLibEditeur();

    $retour="
<div class='d-flex flex-column-reverse flex-md-row font-size-24'>
    <div class='m-1 d-flex flex-column'>
        <div class='d-flex flex-row justify-content-between'>
            <span>{$livre->getTitre()}</span>";

    if($livre->getNoteMoyenne()!=-1)
        $retour.="
            <span class='booki-link'>({$livre->getNbAppreciations()} avis) {$livre->getNoteMoyenne()}/5</span>";
    else
        $retour.="
            <span class='booki-link'>({$livre->getNbAppreciations()} avis) Aucune note</span>";

    $retour.="
        </div>
        <table>
            <tr>
                <td>Prix</td>
                <td class='booki-link'>{$livre->getPrix()} €</td>
            </tr>
            <tr>
                <td>Éditeur</td>
                <td><a href='' class='booki-link'>$editeur</a></td>
            </tr>
            <tr>
                <td>Auteur</td>
                <td>$nomsAuteurs</td>
            </tr>
            <tr>
                <td>Année de publication</td>
                <td class='booki-link'>{$livre->getDatePublication()}</td>
            </tr>
            <tr>
                <td>Genre</td>
                <td>$nomsGenres</td>
            </tr>
            <tr>
               <td>Langue</td>
               <td><a href='' class='booki-link'>{$livre->getLangue()}</a></td>
            </tr>
            <tr>
                <td>ISBN</td>
                <td class='booki-link'>{$livre->getISBN()}</td>
            </tr>
        </table>
        <span>Description :</span>
        <span class='p-3 border-radius-5 description-background description-text'>{$livre->getDescription()}</span>
    </div>
    <img src='./src/ViewCouverture.php?id={$livre->getIdCouv()}'>
</div>
";
    return $retour;
}

function affichageAppreciations(string $isbn):string
{
    $livre=Livre::createFromId($isbn);
    $listeAppreciations=$livre->getAppreciations();
    $retour="<div class='d-flex flex-column justify-content-center'>";
    foreach ($listeAppreciations as $elmt)
    {
        $utilisateur=Utilisateur::createFromId($elmt->getIdUtilisateur())->getPseudo();
        if($utilisateur==null)
            $utilisateur=Utilisateur::createFromId($elmt->getIdUtilisateur())->getNom()." ".Utilisateur::createFromId($elmt->getIdUtilisateur())->getPrenom();
        $retour.="
<div class='d-flex flex-column'>
    <div class='d-flex flex-row justify-content-between'>
        <span>$utilisateur</span>
        <span>{$elmt->getNote()}</span>
    </div>
    <span>{$elmt->getCommentaire()}</span>
</div>
";
    }
    $retour.="</div>";

    return $retour;
}