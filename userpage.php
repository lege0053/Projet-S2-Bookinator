<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();

if(!isLogged())
    header('Location: index.php');

$user = Utilisateur::createFromId($_SESSION['idUtilisateur']);
$webPage = new WebPage("Profil");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");


$webPage->appendContent("TU ES CONNECTE ! ".$user->getNom()." ".$user->getPrenom());

$webPage->appendContent('<form action="disconnect.php" method="post">
                                    <input type="submit" class="btn" name="envoyer" value="envoyer">
                                <form>');

$webPage->appendContent(getFooter());
echo $webPage->toHTML();