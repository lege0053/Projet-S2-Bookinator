<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();


$books = [];

$form = <<<HTML
    <form class="m-2 d-flex flex-column justify-content-center align-items-center" action="addBook_trmt.php" method="post">
        <div class="d-flex form-group w-100">
            <input type="file" name="couverture" class="flex-fill form-control" accept="image/png, image/jpeg" required>
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
            <input type="text" name="editeur" class="flex-fill form-control" placeholder="Editeur" required>
        </div>
        <div class="d-flex form-group w-100">
            <input type="text" name="auteur" class="flex-fill form-control" placeholder="Auteur" required>
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
            <button type="submit" class="flex-fill main-color-background p-3">Ajouter Livre</button>
        </div>
    </form>
HTML;


$webPage = new WebPage("Bookinator");
$webPage->appendCssUrl("src/style.css");
$webPage->appendContent(getHeader());
$webPage->appendContent($form);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();