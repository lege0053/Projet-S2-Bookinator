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
                    <div class="border-radius-5 margin-left margin-right w-25 white-background-color"></div>
                    <div class="border-radius-5 margin-right flex-fill white-background-color"></div>
                    <div class="font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center">
                        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.027 22.896C11.323 22.896 10.731 22.672 10.251 22.224C9.803 21.744 9.579 21.152 9.579 20.448V14.016H3.147C2.443 14.016 1.851 13.776 1.371 13.296C0.923 12.816 0.699 12.224 0.699 11.52C0.699 10.816 0.923 10.24 1.371 9.792C1.851 9.312 2.443 9.072 3.147 9.072H9.579V2.64C9.579 1.968 9.819 1.392 10.299 0.912C10.811 0.431998 11.387 0.191998 12.027 0.191998C12.763 0.191998 13.355 0.431998 13.803 0.912C14.251 1.36 14.475 1.936 14.475 2.64V9.072H20.907C21.579 9.072 22.155 9.312 22.635 9.792C23.147 10.272 23.403 10.864 23.403 11.568C23.403 12.24 23.147 12.816 22.635 13.296C22.155 13.776 21.579 14.016 20.907 14.016H14.475V20.448C14.475 21.152 14.251 21.744 13.803 22.224C13.355 22.672 12.763 22.896 12.027 22.896Z" fill="#2F2F2F"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>
HTML;

$content = <<<HTML
        <div class="d-flex flex-row justify-content-center">
            <div class="form-group d-inline-flex">
                <button class="btn font-size-36 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Favoris</button>
            </div>
        </div>
HTML;

$webPage = new WebPage("Favoris");
$webPage->appendCssUrl("src/style.css");
$webPage->appendContent($research);
$webPage->appendContent($content);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();