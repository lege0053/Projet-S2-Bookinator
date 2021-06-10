<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require "src/ViewLivre.php";
init_php_session();

$id='';
if(isset($_GET['idArticle']) && !empty($_GET['idArticle']) && ctype_digit($_GET['idArticle']))
    $id=$_GET['idArticle'];

try{
    if(Livre::createFromId($id)->getQte()==0)
    {
        header('Location: index.php');
    }
    else
    {
        $webPage = new WebPage("Bookinator - ".Livre::createFromId($id)->getTitre());
        $webPage->appendContent(getHeader());
        $webPage->appendCssUrl("src/style.css");

        $webPage->appendContent(affichageLivre($id));
        if(isLogged())
            $webPage->appendContent(affichageConnecte($id));
        $webPage->appendContent(affichageAppreciations($id));

        $webPage->appendContent(getFooter());
        echo $webPage->toHTML();
    }
}catch(Exception $e)
{
    echo "<script>window.alert('Cette page est indisponible !')</script>";
    echo "<script>window.location.href='index.php'</script>";
}
