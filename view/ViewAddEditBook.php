<?php
declare(strict_types=1);

require_once "autoload.php";

function getFormatListHTML(Livre $livre = null) : String {
    $formatList = Format::getAll();
    $formatListHTML = "";
    foreach($formatList as $format)
    {
        if($livre != null && $format->getIdFormat() == $livre->getIdFormat())
            $formatListHTML .= "<option value='{$format->getIdFormat()}' selected>{$format->getLibFormat()}</option>";
        else
            $formatListHTML .= "<option value='{$format->getIdFormat()}'>{$format->getLibFormat()}</option>";
    }

    $formatHTML = <<<HTML
                <div class="d-flex flex-column form-group w-100">
                    <label for="format" class="white-text-color font-size-20 m-0">Format</label>
                    <select type="text" id="format" name="format" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" required>
                        $formatListHTML
                    </select>
                </div>
    HTML;

    return $formatHTML;
}


function getSupportListHTML(Livre $livre = null) : String {
    $supportList = Support::getAll();
    $supportListHTML = "";
    foreach ($supportList as $support){
        if($livre != null && $support->getIdSupport() == $livre->getIdSupport())
            $supportListHTML .= "<option value='{$support->getIdSupport()}' selected>{$support->getLibSupport()}</option>";
        else
            $supportListHTML .= "<option value='{$support->getIdSupport()}'>{$support->getLibSupport()}</option>";
    }

    $supportHTML = <<<HTML
                <div class="d-flex flex-column form-group w-100">
                    <label for="support" class="white-text-color font-size-20 m-0">Support</label>
                    <select type="text" id="support" name="support" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" placeholder="Support" required>
                        $supportListHTML
                    </select>
                </div>
    HTML;

    return $supportHTML;
}


function getGenreListHTML(Livre $livre) : String {

    $genres = $livre->getGenres();

    $genre = '';
    if(!empty($genres))
        $genre = $genres[0]->getLibGenre();

    $genresHTML = <<<HTML
                    <div class="d-flex flex-column form-group w-100">
                        <label for="genre" class="white-text-color font-size-20 m-0">Genre(s)</label>
                        <div class="d-flex">
                            <input type="text" id="genre" name="genre[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5 margin-right" value="{$genre}" placeholder="Genre" required>
                            <div onclick="addGenre()">
                                <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" rx="5" fill="#E1B74A"/>
                                <path d="M24.027 35.896C23.323 35.896 22.731 35.672 22.251 35.224C21.803 34.744 21.579 34.152 21.579 33.448V27.016H15.147C14.443 27.016 13.851 26.776 13.371 26.296C12.923 25.816 12.699 25.224 12.699 24.52C12.699 23.816 12.923 23.24 13.371 22.792C13.851 22.312 14.443 22.072 15.147 22.072H21.579V15.64C21.579 14.968 21.819 14.392 22.299 13.912C22.811 13.432 23.387 13.192 24.027 13.192C24.763 13.192 25.355 13.432 25.803 13.912C26.251 14.36 26.475 14.936 26.475 15.64V22.072H32.907C33.579 22.072 34.155 22.312 34.635 22.792C35.147 23.272 35.403 23.864 35.403 24.568C35.403 25.24 35.147 25.816 34.635 26.296C34.155 26.776 33.579 27.016 32.907 27.016H26.475V33.448C26.475 34.152 26.251 34.744 25.803 35.224C25.355 35.672 24.763 35.896 24.027 35.896Z" fill="#2F2F2F"/>
                                </svg>
                            </div>
                        </div>
                        <div id="genres-list">
    HTML;

    for($i = 1; $i < count($genres); $i++){

        $id = $i-1;
        $idGenre = "genre-$id";

        $genresHTML .= <<< HTML
            <div id="{$idGenre}" class="d-flex" style="margin-top: 5px;">
                <input type="text" name="genre[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5 margin-right" value="{$genres[$i]->getLibGenre()}" placeholder="Genre" required>
                <div onclick="removeGenre('{$idGenre}')">
                    <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="5" fill="#E1534A"/><path d="M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z" fill="#2F2F2F"/></svg>
                </div>
            </div>;
        HTML;
    }

    $genresHTML.= <<< HTML
                        </div>
                    </div>
    HTML;

    return $genresHTML;
}

function getAuthorListHTML(Livre $livre) : String{

    $authors = $livre->getAuteurs();

    $authorPrnm = '';
    $authorNom = '';
    if(!empty($authors)) {
        $authorPrnm = $authors[0]->getPrnm();
        $authorNom = $authors[0]->getNom();
    }

    $authorsHTML = <<<HTML
                <div class="p-0 d-flex form-group align-items-center justify-content-center flex-column w-100 align-items-end">
                    <div class="m-0 p-0 d-flex align-items-center align-items-md-end flex-column flex-md-row w-100 align-items-end">
                        <div class="d-flex flex-fill flex-column w-100 margin-right">
                            <label for="prenomAuteur" class="flex-fill white-text-color font-size-20 m-0">Prénom Auteur</label>
                            <input type="text" id="prenomAuteur" name="prenomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="$authorPrnm" placeholder="Prénom Auteur" required>
                        </div>
                        <div class="d-flex flex-fill flex-column w-100 margin-right">
                            <label for="nomAuteur" class="flex-fill white-text-color font-size-20 m-0">Nom Auteur</label>
                            <input type="text" id="nomAuteur" name="nomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="$authorNom" placeholder="Nom Auteur" required>
                        </div>
                        <div onclick="addAuthor()">
                            <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="48" height="48" rx="5" fill="#E1B74A"/>
                            <path d="M24.027 35.896C23.323 35.896 22.731 35.672 22.251 35.224C21.803 34.744 21.579 34.152 21.579 33.448V27.016H15.147C14.443 27.016 13.851 26.776 13.371 26.296C12.923 25.816 12.699 25.224 12.699 24.52C12.699 23.816 12.923 23.24 13.371 22.792C13.851 22.312 14.443 22.072 15.147 22.072H21.579V15.64C21.579 14.968 21.819 14.392 22.299 13.912C22.811 13.432 23.387 13.192 24.027 13.192C24.763 13.192 25.355 13.432 25.803 13.912C26.251 14.36 26.475 14.936 26.475 15.64V22.072H32.907C33.579 22.072 34.155 22.312 34.635 22.792C35.147 23.272 35.403 23.864 35.403 24.568C35.403 25.24 35.147 25.816 34.635 26.296C34.155 26.776 33.579 27.016 32.907 27.016H26.475V33.448C26.475 34.152 26.251 34.744 25.803 35.224C25.355 35.672 24.763 35.896 24.027 35.896Z" fill="#2F2F2F"/>
                            </svg>
                        </div>
                    </div>
                    <div id="authors-list" class="d-flex flex-column flex-fill w-100">
    HTML;

    for($i = 1; $i < count($authors); $i++){

        $id = $i-1;
        $idAuthor = "author-$id";

        $authorNom = $authors[$i]->getNom();
        $authorPrnm = $authors[$i]->getPrnm();

        $authorsHTML .= <<< HTML
                            <div id="$idAuthor" class="p-0 d-flex flex-fill align-items-center align-items-md-end flex-column flex-md-row w-100 align-items-end" style="margin-top: 5px;">
                                <div class="d-flex flex-fill flex-column w-100 margin-right">
                                    <input type="text" id="prenomAuteur" name="prenomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="$authorPrnm" placeholder="Prénom Auteur" required>
                                </div>
                                <div class="d-flex flex-fill flex-column w-100 margin-right">
                                    <input type="text" id="nomAuteur" name="nomAuteur[]" class="flex-fill p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="$authorNom" placeholder="Nom Auteur" required>
                                </div>
                                <div class="" onclick="removeAuthor('$idAuthor')">
                                   <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="48" height="48" rx="5" fill="#E1534A"/><path d="M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z" fill="#2F2F2F"/></svg>
                                </div>
                            </div>;
        HTML;
    }

    $authorsHTML .= <<<HTML
                    </div>
                </div>
    HTML;

    return $authorsHTML;
}