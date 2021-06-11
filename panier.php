<?php
declare(strict_types=1);

require_once "autoload.php";
require "src/Utils.php";
init_php_session();

if(!isLogged())
    header('Location: index.php');

$webPage = new WebPage("Panier");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");
$Commande=Utilisateur::createFromId($_SESSION['idUtilisateur'])->getPanier();

$panier = $Commande->getLivres();

$livre="";


if(empty($panier)){
    $livre=<<<HTML
    <div class="w-100 d-flex justify-content-center align-items-center" style="height: 400px;">
        <span class="dark-text font-size-32">Votre panier est vide.</span>
    </div>
    HTML;

}else{
    foreach ($panier as $livres) {


        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT qte
                FROM Contenu
                WHERE ISBN=?
                AND idCmd = ?

    SQL
        );
        $req->execute([$livres->getISBN(), $Commande->getIdCmd()]);
        $qte = $req->fetch();

        $tabAuteurs = $livres->getAuteurs();
        $auteurs = "";
        for ($i = 0; $i < count($tabAuteurs); $i++) {


            $auteurs .= "{$tabAuteurs[$i]->getPrnm()} {$tabAuteurs[$i]->getNom()}";

            if ($i < count($tabAuteurs) - 1) {
                $auteurs .= ",";
            }

        }


        $qteInt=(int)($qte['qte']);
        $prix=$livres->getPrix()*$qteInt;

        $livre .= <<<HTML
    <div class="d-flex flex-row main-background border-radius-10 m-4">
    
       <div class=""> <a href="trmt/article.php?idArticle={$livres->getISBN()} ">  <img height="200" src="./src/ViewCouverture.php?id={$livres->getIdCouv()}" style="border-radius: 5px 0px 0px 5px;"></a> </div> 
       <div class="d-flex second-main-background flex-column flex-fill m-2 p-2 border-radius-5">
           <div class=" white-text-color ">{$livres->getTitre()}</div>
           <div class="d-flex white-text-color"> De : {$auteurs} </div>
           <div class=" main-text-color ">Quantité : {$qte['qte']}</div>
           <div class="d-flex white-text-color flex-fill align-items-end">Langue : {$livres->getLangue()}</div>
       </div>
       
       
       <div class="d-flex flex-column ">
           <div class="d-flex second-main-background main-text-color font-size-20 padding-button  border-radius-5 justify-content-center align-items-center flex-fill  "> {$prix} € </div>
          
           <a href="trmt/supressionPanier_trmt.php?ISBN={$livres->getISBN()}" class="btn d-flex justify-content-center align-items-center font-size-20 bg-danger dark-text border-radius-5  flex-fill padding-button font-weight-bold button">Supprimer</a>
          
       </div>
       
    </div>
  HTML;

    }

    $livre = <<<HTML
        <div class="d-flex flex-row">
            <div class="d-flex flex-grow-1 main-color-background padding-button border-radius-5 font-weight-bold justify-content-center">
                <div class="d-flex font-size-36 dark-text ">Panier</div>
                <form action="" method="post">
                    <a href="trmt/viderPanier_trmt.php" class="btn font-size-15 bg-danger dark-text border-radius-5 padding-button font-weight-bold button">Vider</a>
                </form>
            </div>
        </div>
        
        <div>
            $livre
        
        </div>
        <div class="d-flex flex-row justify-content-center">
            <div class="form-group d-inline-flex">
                <button class="btn font-size-15 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Commander</button>
            </div>
        </div>
    HTML;

}





$html= <<<HTML
<div class="d-flex flex-row justify-content-center margin-topbottom-art">
    <!--Bouton retour-->
    <div class="d-flex flex-column align-items-start padding-button">
        <div onclick="history.back()">
            <svg width="60" height="60" viewBox="0 0 108 108" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d)">
                    <rect x="4" width="100" height="100" rx="50" fill="#E1B74A"/>
                </g>
                <path d="M32 43.6667H64.2667C67.3785 43.6667 70.363 44.8958 72.5634 47.0838C74.7638 49.2717 76 52.2391 76 55.3333C76 58.4275 74.7638 61.395 72.5634 63.5829C70.363 65.7708 67.3785 67 64.2667 67H61.3333M43.7333 55.3333L32 43.6667L43.7333 32V55.3333Z" stroke="#2F2F2F" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                <defs>
                    <filter id="filter0_d" x="0" y="0" width="108" height="108" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
                        <feOffset dy="4"/>
                        <feGaussianBlur stdDeviation="2"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                       <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
                       <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
                    </filter>
                </defs>
            </svg>
        </div>
    </div>
    <div class="d-flex flex-column">
        $livre
    </div>
</div>


HTML;


$webPage->appendContent($html);
$webPage->appendContent(getFooter());
echo $webPage->toHTML();