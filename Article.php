<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require "src/ViewLivre.php";
init_php_session();

$id='9782723488525';
if(isset($_GET['idArticle']) && !empty($_GET['idArticle']) && ctype_digit($_GET['idArticle']))
    $id=$_GET['idArticle'];

$webPage = new WebPage("Article choisi");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");

$webPage->appendContent(affichageLivre($id));
if(isLogged())
    $webPage->appendContent(affichageConnecte($id));
$webPage->appendContent(affichageAppreciations($id));

$webPage->appendContent(getFooter());
echo $webPage->toHTML();