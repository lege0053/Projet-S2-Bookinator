<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";

init_php_session();

$id = '';
$url='';
if (isset($_GET['isbn']))
{
    $id=$_GET['isbn'];
    $url="isbn=$id";
}
else if (isset($_GET['idCmd']))
{
    $id=$_GET['idCmd'];
    $url="idCmd=$id";
}
else if (isset($_GET['idApp']))
{
    $id=$_GET['idApp'];
    $url="idApp=$id";
}

$webPage = new WebPage("Signalement");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");

$form = <<<HTML
<div class="d-flex justify-content-center p-5 ">
    <!--Bouton retour-->
    <div class="d-flex flex-column padding-button">
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

        <div class="d-flex m-5 p-5 main-background flex-column align-items-center border-radius-10 login-form justify-content-center ">
        
            <form action="addSignalement_trmt.php?$url" class="d-flex flex-column" method="post">
                <h2 class="d-flex form-title justify-content-center white-text-color">Signalement</h2>
                <div class="d-flex flex-column form-group ">
                    <div class="white-text-color m-0">Veuillez décrire votre problème : </div>
                    <input type="text" name="contenu" class="form-control second-main-background " style="outline: 0; border:0;" maxlength="500" required>
                </div>
                <div class="d-flex form-group justify-content-center">
                    <button type="submit" class="font-size-20 main-color-background dark-text border-radius-5 padding-button font-weight-bold" style="outline: 0; border:0;">Envoyer</button>
                </div>
            </form>
        </div>

 </div>  
HTML;


$webPage->appendContent($form);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();