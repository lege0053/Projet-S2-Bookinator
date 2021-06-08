<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require "src/ViewResearchBook.php";
init_php_session();

$authors = [];
$genres = [];
$years = [];
$editeurs = [];
$languages = [];
$research = "";
$livres = Livre::getAll();

if( (isset($_GET['author']) && !empty($_GET['author'])) || (isset($_GET['genre']) && !empty($_GET['genre']))
|| (isset($_GET['year']) && !empty($_GET['year'])) || (isset($_GET['editeur']) && !empty($_GET['editeur']))
|| (isset($_GET['langue']) && !empty($_GET['langue'])) || (isset($_GET['research']) && !empty($_GET['research']))) {
    if(isset($_GET['author']) && !empty($_GET['author'])){
        $authors = $_GET['author'];
    }
    if(isset($_GET['genre']) && !empty($_GET['genre'])){
        $genres = $_GET['genre'];
    }
    if(isset($_GET['year']) && !empty($_GET['year'])){
        $years = $_GET['year'];
    }
    if(isset($_GET['editeur']) && !empty($_GET['editeur'])){
        $editeurs = $_GET['editeur'];
    }
    if(isset($_GET['langue']) && !empty($_GET['langue'])){
        $languages = $_GET['langue'];
    }
    if(isset($_GET['research']) && !empty($_GET['research'])){
        $research = $_GET['research'];
    }
    $livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages);
}


$header = getIndexHeader();
$research = <<<HTML
    <div class="header">
        <div class="d-flex flex-column dackdrop-blur h-100">
            $header
            <form class="d-flex justify-content-center flex-column flex-fill align-items-center" action="index.php" method="get">
                <span class="font-size-36 white-text-color">Rechercher</span>
                <div class="form-group research-button d-flex w-50 white-background-color button-no-outline border-radius-100">
                    <button type="submit" class="button-no-outline bg-transparent margin-left">
                        <svg width="36" height="36" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.9461 3.64285C25.5353 3.64285 29.9366 5.4659 33.1816 8.71095C36.4267 11.956 38.2497 16.3572 38.2497 20.9464C38.2497 24.7386 37.0294 28.2449 34.962 31.0972L46.5573 42.6925C47.0586 43.1865 47.35 43.855 47.3706 44.5585C47.3912 45.2621 47.1395 45.9465 46.6679 46.469C46.1963 46.9915 45.5413 47.3119 44.8393 47.3634C44.1373 47.4148 43.4425 47.1933 42.8998 46.7451L42.6922 46.5575L31.097 34.9623C28.1466 37.1049 24.5924 38.256 20.9461 38.25C16.357 38.25 11.9557 36.4269 8.71068 33.1819C5.46563 29.9368 3.64258 25.5356 3.64258 20.9464C3.64258 16.3572 5.46563 11.956 8.71068 8.71095C11.9557 5.4659 16.357 3.64285 20.9461 3.64285ZM20.9461 9.10714C17.8062 9.10714 14.7948 10.3545 12.5745 12.5748C10.3542 14.7951 9.10686 17.8064 9.10686 20.9464C9.10686 24.0864 10.3542 27.0978 12.5745 29.3181C14.7948 31.5384 17.8062 32.7857 20.9461 32.7857C24.0861 32.7857 27.0975 31.5384 29.3178 29.3181C31.5381 27.0978 32.7854 24.0864 32.7854 20.9464C32.7854 17.8064 31.5381 14.7951 29.3178 12.5748C27.0975 10.3545 24.0861 9.10714 20.9461 9.10714Z" fill="#2F2F2F"/>
                        </svg>
                    </button>
                    <input type="text" name="research" class="flex-fill button-no-outline bg-transparent">
                </div>
                <div class="d-flex justify-content-start w-50">
                    <span class="font-size-24 white-text-color">Filtre(s) :</span>
                    <div class="flex-fill">
                        <div class="d-flex flex-column flex-fill">
                            <div class="d-flex flex-fill">
                                <select id="filter-list" class="white-background-color flex-fill button-no-outline">
                                  <option value="author">Auteur</option>
                                  <option value="editeur">Editeur</option>
                                  <option value="genre">Genre</option>
                                  <option value="year">Année</option>
                                  <option value="language">Langue</option>
                                </select>
                                <div class="font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center" onclick="addFilter()">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" rx="5" fill="#E1B74A"/>
                                    <path d="M24.027 35.896C23.323 35.896 22.731 35.672 22.251 35.224C21.803 34.744 21.579 34.152 21.579 33.448V27.016H15.147C14.443 27.016 13.851 26.776 13.371 26.296C12.923 25.816 12.699 25.224 12.699 24.52C12.699 23.816 12.923 23.24 13.371 22.792C13.851 22.312 14.443 22.072 15.147 22.072H21.579V15.64C21.579 14.968 21.819 14.392 22.299 13.912C22.811 13.432 23.387 13.192 24.027 13.192C24.763 13.192 25.355 13.432 25.803 13.912C26.251 14.36 26.475 14.936 26.475 15.64V22.072H32.907C33.579 22.072 34.155 22.312 34.635 22.792C35.147 23.272 35.403 23.864 35.403 24.568C35.403 25.24 35.147 25.816 34.635 26.296C34.155 26.776 33.579 27.016 32.907 27.016H26.475V33.448C26.475 34.152 26.251 34.744 25.803 35.224C25.355 35.672 24.763 35.896 24.027 35.896Z" fill="#2F2F2F"/>
                                    </svg>
                                </div>
                            </div>
                            <div id="filters" class="d-flex flex-column flex-fill">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
HTML;

$content = <<<HTML
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center">
HTML;

foreach ($livres as $livre){
    $content .= printResearchBook($livre->getISBN());
}

$content .= <<<HTML
        </div>
    </div>
HTML;

$webPage = new WebPage("Bookinator");
$webPage->appendCssUrl("src/style.css");
$webPage->appendJsUrl("src/filters.js");
$webPage->appendContent($research);
$webPage->appendContent($content);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();