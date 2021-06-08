<?php
declare(strict_types=1);

require "autoload.php";

function printResearchBook(String $ISBN) {
    $book=Livre::createFromId($ISBN);

    $author = $book->getAuteurs();
    $livreHTML = <<<HTML
        <div class="border-radius-5 main-background d-flex flex-column book-card">
            <div class="d-flex">
                <img height="200" src="./src/ViewCouverture.php?id={$book->getIdCouv()}">
                <span></span>
            </div>
            <div class="d-flex flex-column bottom-card main-color-background flex-fill">
                <span>{$book->getTitre()}</span>
                <span>De : </span>
            </div>
        </div>
    HTML;


    return $livreHTML;

}