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


if($user->getPhotoProfil() == null)
{
    $pdp= <<<HTML
        <svg width="180" height="180" viewBox="0 0 181 181" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="90.5" cy="90.5" r="90.5" fill="#353535"/>
        <path d="M114.555 73.342H105.397V72.401C105.397 68.1973 101.985 64.7856 97.7812 64.7856H83.2155C79.0101 64.7856 75.6001 68.1973 75.6001 72.401V73.342H66.4396C62.2342 73.342 58.8242 76.752 58.8242 80.9574V108.6C58.8242 112.803 62.2342 116.215 66.4396 116.215H114.559C118.764 116.215 122.174 112.803 122.174 108.6V80.9574C122.171 76.7503 118.761 73.342 114.555 73.342ZM90.4958 108.315C82.5623 108.315 76.1112 101.864 76.1112 93.9306C76.1112 85.9988 82.5623 79.546 90.4958 79.546C98.4294 79.546 104.88 85.9971 104.88 93.9306C104.88 101.864 98.4277 108.315 90.4958 108.315ZM98.1112 93.9306C98.1112 98.1259 94.6928 101.546 90.4958 101.546C86.2989 101.546 82.8804 98.1259 82.8804 93.9306C82.8804 89.7337 86.2989 86.3152 90.4958 86.3152C94.6928 86.3152 98.1112 89.7337 98.1112 93.9306Z" fill="#525252"/>
        </svg>
    HTML;
} else {
    $pdp = <<<HTML
        <div class="d-flex align-items-center justify-content-center">
            <label for="input-couverture" class="d-flex align-items-center justify-content-center second-main-background border-radius-10 hover-couverture" style="width: 180px; height: 180px;">
                <img alt="" src="./src/ViewPdP.php?id={$user->getIdUtilisateur()}" height="180" width="180" class="border-radius-100" style="object-fit: cover;">
            </label>
            <input id="input-couverture" type="file" name="couverture" class="flex-fill form-control d-none" accept="image/png, image/jpeg" onchange="previewFile('1')">
       </div>
    HTML;
}

$html = <<<HTML
<div class="d-flex flex-row justify-content-center margin-topbottom-art">
    <!--Bouton retour-->
    <div class="d-flex flex-column align-items-start padding-button">
        <a href="index.php">
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
        </a>
    </div>
    <!--Profil-->
    <div class="d-flex flex-column">
        <div class="d-flex flex-row">
            <div class="d-flex flex-shrink">$pdp</div>                
            <div class="d-flex flex-grow-1 main-color-background padding-button border-radius-5 font-weight-bold justify-content-center">
            <div class="d-flex font-size-36 dark-text align-self-center"> Profil</div>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-around p-2">
            <a href="favoris.php" class="font-size-15 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Mes Favoris</a>
            <form action="disconnect.php" method="post">
                <button type="submit" class="btn font-size-15 bg-danger dark-text border-radius-5 padding-button font-weight-bold button">Se déconnecter</button>
            </form>
        </div>
    <!--Formulaire-->        
        <div class="d-flex flex-column main-background padding-button border-radius-5">
            <form action="profil_trmt.php" method="post" class="p-3">
                 <div class="d-flex flex-row mt-3 justify-content-between">
                    <div class="form-group d-flex flex-column">
                        <div class="white-text-color">Nom</div>
                        <input type="text" name="nom" class="p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$user->getNom()}" required>
                    </div>
                    <div class="form-group d-flex flex-column">
                        <div class="white-text-color">Prénom</div>
                        <input type="text" name="prnm" class="p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$user->getPrenom()}" required>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between">
                     <div class="form-group d-flex flex-column ">
                        <div class="white-text-color">Ville</div>
                        <input type="text" name="ville" class="p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$user->getVille()}">
                     </div>
                     <div class="form-group d-flex flex-column">
                         <div class="white-text-color">Code postal</div>
                         <input type="text" name="CP" class="p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$user->getCP()}">
                     </div>
                </div>
                <div class="form-group d-flex flex-column">
                      <div class="white-text-color">Adresse</div>
                      <input type="text" name="adresse" class="p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$user->getRue()}">
                </div>
                <div class="form-group d-flex flex-column">
                      <div class="white-text-color">Numéro Téléphone</div>
                      <input type="number" name="tel" class="p-2 button-no-outline no-decoration white-text-color second-main-background border-radius-5" value="{$user->getTel()}">
                </div>
                <div class="form-group d-inline-flex">
                    <a href="editMail.php" class="form-title booki-link padding-button">Modifier l'adresse mail</a>
                    <a href="editMdp.php" class="form-title booki-link padding-button">Modifier le mot de passe</a>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    <div class="form-group d-inline-flex">
                        <button type="submit" class="button-no-outline form_submit font-size-20 main-color-background dark-text border-radius-100 padding-button font-weight-bold button">Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;

$webPage->appendContent($html);
$webPage->appendContent(getFooter());
echo $webPage->toHTML();
