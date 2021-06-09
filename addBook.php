<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();


$books = [];

$form = <<<HTML
    <form class="m-2 d-flex flex-column justify-content-center align-items-center" action="trmt/addBook_trmt.php" method="post" enctype="multipart/form-data">
        <div class="d-flex form-group w-100">
            <label for="input-couverture" class="d-flex align-items-center justify-content-center main-background border-radius-10" style="height: 400px; min-width: 240px;">
                <div id="no_image">
                    <svg width="140" height="140" viewBox="0 0 567 567" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M141.75 481.95H510.3V538.65H141.75C94.689 538.65 56.7 500.661 56.7 453.6V113.4C56.7 66.339 94.689 28.35 141.75 28.35H510.3V425.25H141.75C126.157 425.25 113.4 438.007 113.4 453.6C113.4 469.192 126.157 481.95 141.75 481.95ZM198.45 382.725V70.875C198.45 62.937 192.213 56.7 184.275 56.7C176.337 56.7 170.1 62.937 170.1 70.875V382.725C170.1 390.663 176.337 396.9 184.275 396.9C192.213 396.9 198.45 390.663 198.45 382.725Z" fill="#525252"/>
                    </svg>
                </div>
                <img id="couverture" class="border-radius-10" src="" height="400px">
            </label>
            <input id="input-couverture" type="file" name="couverture" class="flex-fill form-control d-none" accept="image/png, image/jpeg" onchange="previewFile()" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="isbn" class="flex-fill form-control" placeholder="ISBN" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="titre" class="flex-fill form-control" placeholder="Titre" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="prix" class="flex-fill form-control" placeholder="Prix" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="nbPages" class="flex-fill form-control" placeholder="Nombre de Page" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="datePublication" class="flex-fill form-control" placeholder="Année Publication" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="genre" class="flex-fill form-control" placeholder="Genre" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="langue" class="flex-fill form-control" placeholder="Langue" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="description" class="flex-fill form-control" placeholder="Description" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="editeur" class="flex-fill form-control" placeholder="Editeur" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="nomAuteur" class="flex-fill form-control" placeholder="Nom Auteur" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="prenomAuteur" class="flex-fill form-control" placeholder="Prénom Auteur" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="format" class="flex-fill form-control" placeholder="Format" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="support" class="flex-fill form-control" placeholder="Support" required>
        </div>
        <div class="d-flex form-group w-100">
            <button type="submit" class="button-no-outline flex-fill main-color-background p-3">Ajouter Livre</button>
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