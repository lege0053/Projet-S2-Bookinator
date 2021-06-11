<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require_once "view/ViewAddEditBook.php";
init_php_session();

if(!isLogged()){
    header('Location: index.php');
}
if(!isAdmin()){
    header('Location: index.php');
}

$ISBN = '';
$livre = '';
if(isset($_GET['isbn']) && !empty($_GET['isbn'])){
    $ISBN = $_GET['isbn'];
    try{
        $livre = Livre::createFromId($ISBN);
    }catch (Exception $e){
        header('Location: index.php');
    }
}
else
    header('Location: index.php');

$editeur = Editeur::createFromId($livre->getIdEditeur());
$genresListHTML = getGenreListHTML($livre);
$authorListHTML = getAuthorListHTML($livre);
$formatHTML = getFormatListHTML($livre);
$supportHTML = getSupportListHTML($livre);

$form = <<<HTML
    <form class="m-2 d-flex flex-column justify-content-center align-items-center" action="trmt/editBook_trmt.php?oldISBN=$ISBN" method="post" enctype="multipart/form-data">
        <div class="container main-background border-radius-10 m-5">
            <div class="d-flex flex-column flex-md-row-reverse justify-content-md-between m-4">
                <div class="d-flex align-items-center justify-content-center">
                    <label for="input-couverture" class="d-flex align-items-center justify-content-center second-main-background border-radius-10 hover-couverture" style="height: 560px; min-width: 320px;">
                        <img id="couverture" class="border-radius-10" src="src/ViewCouverture.php?id={$livre->getIdCouv()}" height="560px">
                    </label>
                    <input id="input-couverture" type="file" name="couverture" class="flex-fill form-control d-none" accept="image/png, image/jpeg" onchange="previewFile('1')">
                </div>
                <div class="d-flex flex-fill align-items-center justify-content-center flex-column w-100" style="margin-right: 20px;">
                    <div class="d-flex flex-column form-group w-100">
                        <label for="isbn" class="white-text-color font-size-20 m-0">ISBN</label>
                        <input type="text" id="isbn" name="isbn" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="ISBN" value="{$livre->getISBN()}" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="titre" class="white-text-color font-size-20 m-0">Titre</label>
                        <input type="text" id="titre" name="titre" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Titre" value="{$livre->getTitre()}" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="prix" class="white-text-color font-size-20 m-0">Prix</label>
                        <input type="number" min="0" step="0.01" id="prix" name="prix" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$livre->getPrix()}" placeholder="Prix" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="nbPages" class="white-text-color font-size-20 m-0">Nombre de Pages</label>
                        <input type="number" min="1" id="nbPages" name="nbPages" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$livre->getNbPages()}" placeholder="Nombre de Page" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="datePublication" class="white-text-color font-size-20 m-0">Année de Publication</label>
                        <input type="text" id="datePublication" name="datePublication" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$livre->getDatePublication()}" placeholder="Année Publication" required>
                    </div>
                    $genresListHTML
                    <div class="d-flex flex-column form-group w-100">
                        <label for="langue" class="white-text-color font-size-20 m-0">Langue</label>
                        <input type="text" id="langue" name="langue" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$livre->getLangue()}" placeholder="Langue" required>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center m-4">
                <div class="d-flex flex-column form-group w-100">
                    <label for="description" class="white-text-color font-size-20 m-0">Description</label>
                    <textarea type="text" id="description" name="description" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" style="resize: none;" rows="8" placeholder="Description" required>{$livre->getDescription()}</textarea>
                </div>
                <div class="d-flex flex-column form-group w-100">
                    <label for="editeur" class="white-text-color font-size-20 m-0">Editeur</label>
                    <input type="text" id="editeur" name="editeur" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$editeur->getLibEditeur()}" placeholder="Editeur" required>
                </div>
                $authorListHTML
                $formatHTML
                $supportHTML
                <div class="d-flex flex-column form-group w-100">
                        <label for="nbPages" class="white-text-color font-size-20 m-0">Quantité en Stock</label>
                        <input type="number" min="0" id="qte" name="qte" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$livre->getQte()}" placeholder="Quantité en Stock" required>
                    </div>
                <div class="d-flex form-group w-50" style="margin-top: 20px;">
                    <button type="submit" class="button-no-outline flex-fill border-radius-100 dark-text main-color-background p-3">Sauvegarder</button>
                </div>
            </div>
        </div>
    </form>
HTML;


$webPage = new WebPage("Bookinator");
$webPage->appendCssUrl("src/style.css");
$webPage->appendJsUrl("js/addBook.js");
$webPage->appendJsUrl("js/image.js");
$webPage->appendContent(getHeader());
$webPage->appendContent($form);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();