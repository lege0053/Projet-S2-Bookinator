<?php


declare(strict_types=1);

require_once "autoload.php";
require "src/Utils.php";
init_php_session();

if(!isLogged()){
    header('Location: index.php');
}

$idCommande = 0;
if(isset($_GET['idCmd']) && !empty($_GET['idCmd']) && ctype_digit($_GET['idCmd'])){
    $idCommande = (int)($_GET['idCmd']);
}else
    header('Location: index.php');

$webPage = new WebPage("Panier");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");

$commande = Commande::createFromId($idCommande);


$CP=$commande->getCPLivraison();
$numCmd=$commande->getIdCmd();
$ville=$commande->getVilleLivraison();
$adr=$commande->getRueLivraison();
$prix=$commande->getPrixCmd();
$panier = $commande->getLivres();
$idStatut = $commande->getStatus()['idStatus'];
$statut = $commande->getStatus()['libStatus'];

$color = '';
if($idStatut == 1){
    $color = '#4F9649';
}else{
    $color = '#A63F3F';
}

$livre="";

foreach ($panier as $livres) {

    $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT qte
                FROM Contenu 
                WHERE ISBN=?
    SQL
    );
    $req->execute([$livres->getISBN()]);
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
    $prixL=$livres->getPrix()*$qteInt;

    $livre .= <<<HTML
    <div class="container d-flex flex-row main-background border-radius-10 p-0" style="margin-bottom: 20px;">
       <div class=""> <a href="article.php?idArticle={$livres->getISBN()} ">  <img height="200" src="./src/ViewCouverture.php?id={$livres->getIdCouv()}" style="border-radius: 5px 0px 0px 5px;"></a> </div> 
       <div class="d-flex second-main-background flex-column flex-fill p-4 border-radius-5" style="margin: 15px;">
           <div class=" white-text-color ">{$livres->getTitre()}</div>
           <div class="d-flex white-text-color"> De : {$auteurs} </div>
           <div class=" main-text-color ">Quantité : {$qte['qte']}</div>
           <div class="d-flex white-text-color flex-fill align-items-end">Langue : {$livres->getLangue()}</div>
       </div>
    
       <div class="d-flex second-main-background align-items-center justify-content-center main-text-color font-size-20 p-3 border-radius-5 flex-fill" style="margin: 15px; margin-left: 0;"> {$prixL} € </div>
    </div>

HTML;
}

$html = <<<HTML
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
        <div class="d-flex flex-column w-100 justify-content-center"  style="margin-bottom: 30px;"> 
            <div class="d-flex flex-column flex-fill main-background padding-button h-100 border-radius-10 container p-3 m-0">
                <div class="row p-2">
                        <div class="col">
                            <div class="white-text-color ">N°Commande</div>
                            <div class="d-flex justify-content-center align-items-center form-control second-main-background button-no-outline font-size-10 white-text-color">$numCmd</div>
                        </div>
                        <div class="col">
                            <div class="white-text-color">Statut</div>
                            <div class="d-flex justify-content-center align-items-center form-control button-no-outline font-size-10 white-text-color" style="background-color: $color;">$statut</div>
                        </div>
                </div>
                <div class="row p-2">
                     <div class="col d-flex align-items-end">
                        <div class="white-text-color font-size-20">Adresse de livraison</div>
                     </div>
                     <div class="col">
                         <div class="white-text-color">Prix</div>
                         <div class="d-flex justify-content-center align-items-center form-control second-main-background  button-no-outline font-size-10 white-text-color">$prix €</div>
                     </div>
                </div>
                <div class="row p-2">
                     <div class="col">
                         <div class="white-text-color ">Ville</div>
                         <div class="d-flex justify-content-center align-items-center form-control second-main-background button-no-outline font-size-10 white-text-color">$ville</div>
                     </div>
                     <div class="col">
                         <div class="white-text-color">Code postal</div>
                         <div class="d-flex justify-content-center align-items-center form-control second-main-background  button-no-outline font-size-10 white-text-color">$CP</div>
                     </div>
                </div>
                <div class="form-group d-flex flex-column p-2">
                     <div class="white-text-color">Adresse</div>
                     <div class="d-flex justify-content-center align-items-center form-control second-main-background  button-no-outline font-size-10 white-text-color">$adr</div>
                </div> 
            </div>
            </div>
            <div class="d-flex  flex-column">
                $livre
            </div>
        </div>
    </div>
   </div>
  


HTML;



$webPage->appendContent($html);
$webPage->appendContent(getFooter());
echo $webPage->toHTML();
