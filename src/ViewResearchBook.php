<?php
declare(strict_types=1);

require "autoload.php";

function printResearchBook(String $ISBN) {
    $book=Livre::createFromId($ISBN);

    $authors = $book->getAuteurs();
    $note = $book->getNoteMoyenne();
    if($note == -1)
        $note = "Aucune note";
    $livreHTML = <<<HTML
        <a href="./article.php?idArticle=$ISBN" class="no-decoration dark-text border-radius-5 main-background d-flex flex-column book-card">
            <div class="d-flex">
                <img height="200" src="./src/ViewCouverture.php?id={$book->getIdCouv()}">
                <div class="d-flex flex-fill flex-column align-items-center justify-content-between main-text-color">
                    <span class="d-flex font-size-24 main-text-color" style="text-align: center">$note</span>
                    <span class="font-size-36 main-text-color">{$book->getPrix()} €</span>
                </div>
            </div>
            <div class="d-flex flex-column bottom-card main-color-background flex-fill infos">
                <span>{$book->getTitre()}</span>
                <span>De : 
    HTML;
    foreach($authors as $author){
        $livreHTML .= $author->getPrnm()." ".$author->getNom();
    }
    $livreHTML .= <<<HTML
                </span>
            </div>
        </a>
    HTML;


    return $livreHTML;

}