<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";

init_php_session();

if(!isLogged())
    header('Location: index.php');

$webPage = new WebPage("Vos commandes : ");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");
$html=<<<HTML
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
HTML;

$listeCommandes=Utilisateur::createFromId($_SESSION['idUtilisateur'])->getCommandes();

foreach($listeCommandes as $commande)
{
    if($commande->getStatus()['idStatus']!=3)
    {
        $color = '';
        if($commande->getStatus()['idStatus'] == 1){
            $color = '#4F9649';
        }else{
            $color = '#A63F3F';
        }
        $html .= <<<HTML

        <div class="d-flex flex-column w-100 justify-content-center"  style="margin-bottom: 30px;"> 
            <div class="d-flex flex-column flex-fill main-background padding-button h-100 border-radius-10 container p-3 m-0">
                <div class="row p-2">
                        <div class="col">
                            <div class="white-text-color ">N°Commande</div>
                            <div class="d-flex justify-content-center align-items-center form-control second-main-background button-no-outline font-size-10 white-text-color">{$commande->getIdCmd()}</div>
                        </div>
                        <div class="col">
                            <div class="white-text-color">Statut</div>
                            <div class="d-flex justify-content-center align-items-center form-control button-no-outline font-size-10 white-text-color" style="background-color: $color;">{$commande->getStatus()['libStatus']}</div>
                        </div>
                </div>
                <div class="row p-2">
                     <div class="col d-flex align-items-end">
                        <div class="white-text-color font-size-20">Adresse de livraison</div>
                     </div>
                     <div class="col">
                         <div class="white-text-color">Prix</div>
                         <div class="d-flex justify-content-center align-items-center form-control second-main-background  button-no-outline font-size-10 white-text-color">{$commande->getPrixCmd()} €</div>
                     </div>
                </div>
                <div class="row p-2">
                     <div class="col">
                         <div class="white-text-color ">Ville</div>
                         <div class="d-flex justify-content-center align-items-center form-control second-main-background button-no-outline font-size-10 white-text-color">{$commande->getVilleLivraison()}</div>
                     </div>
                     <div class="col">
                         <div class="white-text-color">Code postal</div>
                         <div class="d-flex justify-content-center align-items-center form-control second-main-background  button-no-outline font-size-10 white-text-color">{$commande->getCPLivraison()}</div>
                     </div>
                </div>
                <div class="form-group d-flex flex-column p-2">
                     <div class="white-text-color">Adresse</div>
                     <div class="d-flex justify-content-center align-items-center form-control second-main-background  button-no-outline font-size-10 white-text-color">{$commande->getRueLivraison()}</div>
                </div> 
                <div>
                    <a href='commandeInfo.php?idCmd={$commande->getIdCmd()}' class='justify-content-center d-flex flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button'>Plus d'info !</a>";
                </div>
                <div class="d-flex justify-content-center">
                    <a href='addSignalement.php?idCmd={$commande->getIdCmd()}' style='margin-top: 10px;'><svg width='28' height='28' viewBox='0 0 28 28' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M21.7543 2.34259C18.8115 0.38662 15.2787 -0.38085 11.7948 0.177827C11.7341 0.178975 11.6735 0.184827 11.6128 0.195326C7.9295 0.834447 4.71503 2.86977 2.56077 5.92559C0.408855 8.98261 -0.425114 12.6939 0.212913 16.3785C0.319059 16.9861 0.46715 17.5985 0.653795 18.1933C1.42476 20.6974 1.23462 23.3812 0.119618 25.7501C-0.0751751 26.1606 -0.0110279 26.6482 0.281763 26.9969C0.5745 27.3457 1.03873 27.4903 1.48191 27.3713L6.71065 25.9437C8.92441 27.299 11.4238 28 13.9758 28C14.9031 28 15.8373 27.9078 16.7669 27.72C20.4328 26.9817 23.5913 24.8613 25.6604 21.7483C29.9327 15.3218 28.1809 6.61726 21.7543 2.34259ZM23.7184 20.4572C21.9934 23.0523 19.3609 24.8194 16.3074 25.434C13.2562 26.0487 10.1444 25.4375 7.54811 23.7114C7.35452 23.5831 7.12938 23.5166 6.90194 23.5166C6.79929 23.5166 6.6955 23.5306 6.594 23.5586L3.0343 24.5301C3.63497 22.2371 3.59062 19.8087 2.8815 17.5005C2.72406 16.9978 2.59926 16.4858 2.51177 15.9796C1.97989 12.9098 2.67506 9.81658 4.46888 7.26923C6.23241 4.76509 8.85085 3.08436 11.8566 2.52333C11.9126 2.52098 11.9674 2.51518 12.0234 2.50583C14.9731 1.99615 17.9706 2.62947 20.4643 4.28685C25.8202 7.84776 27.2792 15.1013 23.7184 20.4572Z' fill='#E2574C'/>
                        <path d='M14.0042 6.8855C13.3593 6.8855 12.8379 7.40688 12.8379 8.05185V15.05C12.8379 15.6949 13.3593 16.2163 14.0042 16.2163C14.6492 16.2163 15.1706 15.6938 15.1706 15.05V8.05185C15.1706 7.40688 14.6493 6.8855 14.0042 6.8855Z' fill='#E2574C'/>
                        <path d='M15.0761 19.3876C15.0178 19.236 14.9362 19.1077 14.8312 19.0028C14.7729 18.9561 14.7145 18.8978 14.6446 18.8628C14.5863 18.8162 14.5163 18.7823 14.4463 18.7578C14.3763 18.7217 14.3063 18.6995 14.2247 18.6878C13.8526 18.6062 13.4432 18.7356 13.1761 19.0028C13.0711 19.1077 12.9895 19.2361 12.9312 19.3876C12.8729 19.5276 12.8379 19.6792 12.8379 19.8309C12.8379 19.9825 12.8729 20.1341 12.9312 20.2741C12.9895 20.4141 13.0711 20.5423 13.1761 20.659C13.2928 20.7639 13.4211 20.8456 13.561 20.9039C13.701 20.9622 13.8526 20.9972 14.0042 20.9972C14.1559 20.9972 14.3063 20.9622 14.4463 20.9039C14.5862 20.8456 14.7134 20.764 14.8312 20.659C14.9362 20.5423 15.0177 20.4141 15.0761 20.2741C15.1344 20.1342 15.1694 19.9825 15.1694 19.8309C15.1694 19.6792 15.1344 19.5276 15.0761 19.3876Z' fill='#E2574C'/>
                    </svg><a>
                </div>
            </div>
       </div>
HTML;
    }
}
$html.=<<<HTML
        </div>
    </div>
</div>
HTML;

$webPage->appendContent($html);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();

