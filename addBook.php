<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();


$form = <<<HTML
    <form class="m-2 d-flex flex-column justify-content-center align-items-center" action="trmt/addBook_trmt.php" method="post" enctype="multipart/form-data">
        <div class="container main-background border-radius-10 m-5">
            <div class="d-flex flex-row-reverse justify-content-between m-4">
                <div class="d-flex align-items-center justify-content-center">
                    <label for="input-couverture" class="d-flex align-items-center justify-content-center second-main-background border-radius-10" style="height: 560px; min-width: 320px;">
                        <div id="no_image">
                            <svg width="140" height="140" viewBox="0 0 567 567" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M141.75 481.95H510.3V538.65H141.75C94.689 538.65 56.7 500.661 56.7 453.6V113.4C56.7 66.339 94.689 28.35 141.75 28.35H510.3V425.25H141.75C126.157 425.25 113.4 438.007 113.4 453.6C113.4 469.192 126.157 481.95 141.75 481.95ZM198.45 382.725V70.875C198.45 62.937 192.213 56.7 184.275 56.7C176.337 56.7 170.1 62.937 170.1 70.875V382.725C170.1 390.663 176.337 396.9 184.275 396.9C192.213 396.9 198.45 390.663 198.45 382.725Z" fill="#353535"/>
                            </svg>
                        </div>
                        <img id="couverture" class="border-radius-10 hover-couverture" src="" height="560px">
                    </label>
                    <input id="input-couverture" type="file" name="couverture" class="flex-fill form-control d-none" accept="image/png, image/jpeg" onchange="previewFile()" required>
                </div>
                <div class="d-flex flex-fill align-items-center justify-content-center flex-column" style="margin-right: 20px;">
                    <div class="d-flex flex-column form-group w-100">
                        <label for="isbn" class="white-text-color font-size-20 m-0">ISBN</label>
                        <input type="text" id="isbn" name="isbn" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="ISBN" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="titre" class="white-text-color font-size-20 m-0">Titre</label>
                        <input type="text" id="titre" name="titre" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Titre" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="prix" class="white-text-color font-size-20 m-0">Prix</label>
                        <input type="text" id="prix" name="prix" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Prix" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="nbPages" class="white-text-color font-size-20 m-0">Nombre de Pages</label>
                        <input type="text" id="nbPages" name="nbPages" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Nombre de Page" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="datePublication" class="white-text-color font-size-20 m-0">Année de Publication</label>
                        <input type="text" id="datePublication" name="datePublication" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Année Publication" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="genre" class="white-text-color font-size-20 m-0">Genre(s)</label>
                        <input type="text" id="genre" name="genre" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Genre" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="langue" class="white-text-color font-size-20 m-0">Langue</label>
                        <input type="text" id="langue" name="langue" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Langue" required>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column align-items-center m-4">
                <div class="d-flex flex-column form-group w-100">
                    <label for="description" class="white-text-color font-size-20 m-0">Description</label>
                    <textarea type="text" id="description" name="description" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" style="resize: none;" rows="8" placeholder="Description" required></textarea>
                </div>
                <div class="d-flex flex-column form-group w-100">
                    <label for="editeur" class="white-text-color font-size-20 m-0">Editeur</label>
                    <input type="text" id="editeur" name="editeur" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Editeur" required>
                </div>
                <div class="d-flex flex-column form-group w-100">
                    <label for="nomAuteur" class="white-text-color font-size-20 m-0">Nom Auteur</label>
                    <input type="text" id="nomAuteur" name="nomAuteur" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Nom Auteur" required>
                </div>
                <div class="d-flex flex-column form-group w-100">
                    <label for="prenomAuteur" class="white-text-color font-size-20 m-0">Prénom Auteur</label>
                    <input type="text" id="prenomAuteur" name="prenomAuteur" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Prénom Auteur" required>
                </div>
                <div class="d-flex flex-column form-group w-100">
                    <label for="format" class="white-text-color font-size-20 m-0">Id Format</label>
                    <input type="text" id="format" name="format" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Format" required>
                </div>
                <div class="d-flex flex-column form-group w-100">
                    <label for="support" class="white-text-color font-size-20 m-0">Id Support</label>
                    <input type="text" id="support" name="support" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Support" required>
                </div>
                <div class="d-flex form-group w-50" style="margin-top: 20px;">
                    <button type="submit" class="button-no-outline flex-fill border-radius-100 dark-text main-color-background p-3">Ajouter Livre</button>
                </div>
            </div>
        </div>
    </form>
HTML;


$webPage = new WebPage("Bookinator");
$webPage->appendCssUrl("src/style.css");
$webPage->appendJsUrl("js/image.js");
$webPage->appendContent(getHeader());
$webPage->appendContent($form);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();