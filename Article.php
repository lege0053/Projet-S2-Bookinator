<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";

$id=0;
if(isset($_POST['idArticle']) && !empty($_POST['idArticle']) && ctype_digit($_POST['idArticle']))
    $id=$_POST['idArticle'];


$livre=Livre::createFromId($id);

$listeAuteur=$livre->getAuteurs();

$nomsAuteurs='';
for($i=0; $i<count($listeAuteur);$i++)
{
    $nomAuteurs.="<a href=''>{$listeAuteur[$i]->getNom()} {$listeAuteur[$i]->getPrnm()}</a>";
    if($i!=count($listeAuteur)-1 && count($listeAuteur)!=1)
        $nomAuteurs.=", ";
}

$listeGenre=$livre->getGenres();

$nomsGenres='';
for($i=0; $i<count($listeGenre);$i++)
{
    $nomsGenres.="<a href=''>{$listeGenre[$i]->getNom()}</a>";
    if($i!=count($listeGenre)-1 && count($listeGenre)!=1)
        $nomsGenres.=", ";
}

$couverture=Couverture::createFromId($livre->getIdCouv());





$webPage = new WebPage("Article choisi");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");
$webPage->appendContent("
<div class='d-flex flex-row'>
    <div class='d-flex flex-column'>
        <div class='d-flex flex-row justify-content-between'>
            <span>{$livre->getTitre()}</span>
            <span>({$livre->getNbAppreciations()} avis) {$livre->getNoteMoyenne()}/5</span>
        </div>
        <table>
            <tr>
                <td>Prix</td>
                <td>{$livre->getPrix()}</td>
            </tr>
            <tr>
                <td>Éditeur</td>
                <td><a href=''>{(Editeur::createFromId($livre->getIdEditeur()))->getLibEditeur()}</a></td>
            </tr>
            <tr>
                <td>Auteur</td>
                <td>$nomsAuteurs</td>
            </tr>
            <tr>
                <td>Date de publication</td>
                <td>{$livre->getDatePublication()}</td>
            </tr>
            <tr>
                <td>Genre</td>
                <td>$nomsGenres</td>
            </tr>
            <tr>
               <td>Langue</td>
               <td><a href=''>{$livre->getLangue()}</a></td>
            </tr>
        </table>
        <span>Description :</span>
        <span>{$livre->getDescription()}</span>
    </div>
    <span>{$couverture->getPng()}</span>
</div>
<div class='d-flex flex-column'>

</div>
");











$webPage->appendContent(getFooter());
echo $webPage->toHTML();