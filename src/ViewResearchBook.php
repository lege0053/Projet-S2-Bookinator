<?php
declare(strict_types=1);

require "autoload.php";

function printResearchBook(String $ISBN) {
    $book=Livre::createFromId($ISBN);

    $author = $book->getAuteurs();
    $livreHTML = <<<HTML
        <div class="border-radius-5 main-color-background d-flex flex-column book-card">
            <div class="d-flex">
            
            </div>
            <div class="d-flex">
                <span></span>
                <span>De : </span>
            </div>
        </div>
    HTML;


    return $livreHTML;

}