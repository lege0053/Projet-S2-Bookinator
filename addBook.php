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

$formatHTML = getFormatListHTML();
$supportHTML = getSupportListHTML();

$form = <<<HTML
    <form class="m-2 d-flex flex-column justify-content-center align-items-center" action="trmt/addBook_trmt.php" method="post" enctype="multipart/form-data">
        <div class="container main-background border-radius-10 m-5">
            <div class="d-flex flex-column flex-md-row-reverse justify-content-md-between m-4">
                <div class="d-flex align-items-center justify-content-center">
                    <label for="input-couverture" class="d-flex align-items-center justify-content-center second-main-background border-radius-10 hover-couverture" style="height: 560px; min-width: 320px;">
                        <div id="no_image">
                            <svg width="140" height="140" viewBox="0 0 567 567" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M141.75 481.95H510.3V538.65H141.75C94.689 538.65 56.7 500.661 56.7 453.6V113.4C56.7 66.339 94.689 28.35 141.75 28.35H510.3V425.25H141.75C126.157 425.25 113.4 438.007 113.4 453.6C113.4 469.192 126.157 481.95 141.75 481.95ZM198.45 382.725V70.875C198.45 62.937 192.213 56.7 184.275 56.7C176.337 56.7 170.1 62.937 170.1 70.875V382.725C170.1 390.663 176.337 396.9 184.275 396.9C192.213 396.9 198.45 390.663 198.45 382.725Z" fill="#353535"/>
                            </svg>
                        </div>
                        <img id="couverture" class="border-radius-10" src="" height="560px">
                    </label>
                    <input id="input-couverture" type="file" name="couverture" class="flex-fill form-control d-none" accept="image/png, image/jpeg" onchange="previewFile('0')" required>
                </div>
                <div class="d-flex flex-fill align-items-center justify-content-center flex-column w-100" style="margin-right: 20px;">
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
                        <input type="number" min="0" step="0.01" id="prix" name="prix" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Prix" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="nbPages" class="white-text-color font-size-20 m-0">Nombre de Pages</label>
                        <input type="number" min="1" id="nbPages" name="nbPages" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Nombre de Page" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="datePublication" class="white-text-color font-size-20 m-0">Année de Publication</label>
                        <input type="text" id="datePublication" name="datePublication" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Année Publication" required>
                    </div>
                    <div class="d-flex flex-column form-group w-100">
                        <label for="genre" class="white-text-color font-size-20 m-0">Genre(s)</label>
                        <div class="d-flex">
                            <input type="text" id="genre" name="genre[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5 margin-right" placeholder="Genre" required>
                            <div onclick="addGenre()">
                                <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="5" fill="#E1B74A"/>
                                <path d="M24.027 35.896C23.323 35.896 22.731 35.672 22.251 35.224C21.803 34.744 21.579 34.152 21.579 33.448V27.016H15.147C14.443 27.016 13.851 26.776 13.371 26.296C12.923 25.816 12.699 25.224 12.699 24.52C12.699 23.816 12.923 23.24 13.371 22.792C13.851 22.312 14.443 22.072 15.147 22.072H21.579V15.64C21.579 14.968 21.819 14.392 22.299 13.912C22.811 13.432 23.387 13.192 24.027 13.192C24.763 13.192 25.355 13.432 25.803 13.912C26.251 14.36 26.475 14.936 26.475 15.64V22.072H32.907C33.579 22.072 34.155 22.312 34.635 22.792C35.147 23.272 35.403 23.864 35.403 24.568C35.403 25.24 35.147 25.816 34.635 26.296C34.155 26.776 33.579 27.016 32.907 27.016H26.475V33.448C26.475 34.152 26.251 34.744 25.803 35.224C25.355 35.672 24.763 35.896 24.027 35.896Z" fill="#2F2F2F"/>
                                </svg>
                            </div>
                        </div>
                        <div id="genres-list">
                        </div>
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
                <div class="p-0 d-flex form-group align-items-center justify-content-center flex-column w-100 align-items-end">
                    <div class="m-0 p-0 d-flex align-items-center align-items-md-end flex-column flex-md-row w-100 align-items-end">
                        <div class="d-flex flex-fill flex-column w-100 margin-right">
                            <label for="prenomAuteur" class="flex-fill white-text-color font-size-20 m-0">Prénom Auteur</label>
                            <input type="text" id="prenomAuteur" name="prenomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Prénom Auteur" required>
                        </div>
                        <div class="d-flex flex-fill flex-column w-100 margin-right">
                            <label for="nomAuteur" class="flex-fill white-text-color font-size-20 m-0">Nom Auteur</label>
                            <input type="text" id="nomAuteur" name="nomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Nom Auteur" required>
                        </div>
                        <div onclick="addAuthor()">
                            <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="48" height="48" rx="5" fill="#E1B74A"/>
                            <path d="M24.027 35.896C23.323 35.896 22.731 35.672 22.251 35.224C21.803 34.744 21.579 34.152 21.579 33.448V27.016H15.147C14.443 27.016 13.851 26.776 13.371 26.296C12.923 25.816 12.699 25.224 12.699 24.52C12.699 23.816 12.923 23.24 13.371 22.792C13.851 22.312 14.443 22.072 15.147 22.072H21.579V15.64C21.579 14.968 21.819 14.392 22.299 13.912C22.811 13.432 23.387 13.192 24.027 13.192C24.763 13.192 25.355 13.432 25.803 13.912C26.251 14.36 26.475 14.936 26.475 15.64V22.072H32.907C33.579 22.072 34.155 22.312 34.635 22.792C35.147 23.272 35.403 23.864 35.403 24.568C35.403 25.24 35.147 25.816 34.635 26.296C34.155 26.776 33.579 27.016 32.907 27.016H26.475V33.448C26.475 34.152 26.251 34.744 25.803 35.224C25.355 35.672 24.763 35.896 24.027 35.896Z" fill="#2F2F2F"/>
                            </svg>
                        </div>
                    </div>
                    <div id="authors-list" class="d-flex flex-column flex-fill w-100">
                    </div>
                </div>
                $formatHTML
                $supportHTML
                <div class="d-flex flex-column form-group w-100">
                        <label for="nbPages" class="white-text-color font-size-20 m-0">Quantité en Stock</label>
                        <input type="number" min="0" id="qte" name="qte" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Quantité en Stock" required>
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
$webPage->appendJsUrl("js/addBook.js");
$webPage->appendJsUrl("js/image.js");
$webPage->appendContent(getHeader());
$webPage->appendContent($form);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();