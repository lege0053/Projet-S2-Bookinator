<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require "src/ViewLivre.php";

$id='2709642522';
if(isset($_POST['idArticle']) && !empty($_POST['idArticle']) && ctype_digit($_POST['idArticle']))
    $id=$_POST['idArticle'];

$webPage = new WebPage("Article choisi");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");

$webPage->appendContent(affichageLivre($id));
$webPage->appendContent(affichageAppreciations($id));

$webPage->appendContent(getFooter());
echo $webPage->toHTML();