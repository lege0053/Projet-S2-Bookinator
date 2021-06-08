<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();


$books = [];

$header = getIndexHeader();
$research = <<<HTML
    <div class="header">
        <div class="d-flex flex-column dackdrop-blur h-100">
            $header
            <form class="d-flex justify-content-center flex-column flex-fill align-items-center" action="index.php" method="get">
                <span class="font-size-36 white-text-color">Rechercher</span>
                <div class="form-group research-button d-flex w-50">
                    <input type="text" name="research" class="research-button flex-fill white-background-color">
                </div>
                <div class="d-flex justify-content-start w-50">
                    <span class="font-size-24 white-text-color">Filtre(s) :</span>
                    <div class="flex-fill">
                        <div class="d-flex flex-column flex-fill">
                            <div class="d-flex flex-fill">
                                <select id="filter-list" class="flex-fill">
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
HTML;

$webPage = new WebPage("Bookinator");
$webPage->appendCssUrl("src/style.css");
$webPage->appendJsUrl("src/filters.js");
$webPage->appendContent($research);
$webPage->appendContent($content);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();