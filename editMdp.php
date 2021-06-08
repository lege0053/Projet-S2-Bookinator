<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();

$webPage = new WebPage("Modifier le mot de passe");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");

$form = <<<HTML
<div class="d-flex flex-row justify-content-center margin-topbottom-art">
    <!--Bouton retour-->
    <div class="d-flex flex-column align-items-start padding-button">
        <a href="userpage.php">
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
    
    <div class="d-flex flex-column main-background padding-button border-radius-5">
        <div class="login-form">
            <form action="editMdp_trmt.php" method="post" class="padding-button">
                <div class="d-flex flex-row justify-content-center">
                    <div class="form-group d-inline-flex">
                        <h2 class="form-title white-text-color">Changement du mot de passe</h2>
                    </div>
                </div> 
                <div class="form-group d-flex flex-column">
                    <div class="white-text-color">Ancien mot de passe</div>
                    <input type="password" name="mdp" class="form-control second-main-background font-size-10 white-text-color" required>
                </div>
                <div class="form-group d-flex flex-column">
                    <div class="white-text-color">Nouveau mot de passe</div>
                    <input type="password" name="mdp" class="form-control second-main-background font-size-10 white-text-color" required>
                </div>
                <div class="form-group d-flex flex-column">
                     <div class="white-text-color">Confirmation du nouveau mot de passe</div>
                     <input type="password" name="repeat_mail" class="form-control second-main-background font-size-10 white-text-color" required>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    <div class="form-group d-inline-flex">
                        <button type="submit" class="form_submit font-size-15 main-color-background dark-text border-radius-5 padding-button font-weight-bold button ">Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;


$webPage->appendContent($form);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();