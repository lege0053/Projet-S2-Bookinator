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
                <div class="d-flex flex-fill flex-column justify-content-between align-items-center main-text-color">
                    <span class="d-flex font-size-20 main-text-color" style="text-align: center">$note</span>
                    <span class="font-size-28 main-text-color">{$book->getPrix()} €</span>
                </div>
            </div>
            <div class="d-flex flex-column justify-content-between bottom-card main-color-background flex-fill infos">
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

function printResearchBookAdmin(String $ISBN) {
    $book=Livre::createFromId($ISBN);

    $authors = $book->getAuteurs();
    $note = $book->getNoteMoyenne();
    if($note == -1)
        $note = "Aucune note";
    $livreHTML = <<<HTML
    <a href="./article.php?idArticle=$ISBN" class="d-flex flex-row main-background border-radius-5 m-4">    
       <div class=""><img height="200" src="./src/ViewCouverture.php?id={$book->getIdCouv()}" style="border-radius: 5px 0px 0px 5px;"> </div> 
       <div class="second-main-background white-text-color m-2 p-2 border-radius-5">{$book->getTitre()}<br><span>De :  
    HTML;
    foreach($authors as $author){
        $livreHTML .= $author->getPrnm()." ".$author->getNom();
    }
    $livreHTML .= <<<HTML
        </span></div>
        <div class="d-flex flex-column justify-content-center">
            <form action="editBook.php" method="post">
                <button type="submit" class="btn font-size-15 main-color-background dark-text border-radius-5 font-weight-bold button">Éditer</button>
            </form>
            <form action="deleteBook.php" method="post">
                <button type="submit" class="btn font-size-15 bg-danger dark-text border-radius-5 font-weight-bold button">Supprimer</button>
            </form>          
        </div>
    </a>
    HTML;

    return $livreHTML;

}