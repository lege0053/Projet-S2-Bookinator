<?php
declare(strict_types=1);

function printResearchBook(String $ISBN) {
    $book=Livre::createFromId($ISBN);


}