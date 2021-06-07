<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";
init_php_session();

$webPage = new WebPage("Connexion");
$webPage->appendContent(getHeader());
$webPage->appendCssUrl("src/style.css");

$form = <<<HTML

         <a href="index.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">
            <svg width="52" height="43" viewBox="0 0 52 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 15.6667H36.2667C39.3785 15.6667 42.363 16.8958 44.5634 19.0838C46.7638 21.2717 48 24.2391 48 27.3333C48 30.4275 46.7638 33.395 44.5634 35.5829C42.363 37.7708 39.3785 39 36.2667 39H33.3333M15.7333 27.3333L4 15.6667L15.7333 4V27.3333Z" stroke="#2F2F2F" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>

        <div class="d-flex m-5 p-5 main-background flex-column align-items-center border-radius-10 login-form justify-content-center ">
        
            <form action="connexion_trmt.php" class="w-75" method="post">
                <h2 class="d-flex form-title justify-content-center white-text-color">Connexion</h2>
                <div class="d-flex flex-column form-group ">
                    <p class="white-text-color m-0">Adresse Mail</p>
                    <input type="email" name="mail"  class="form-control second-main-background " style="outline: 0; border:0;" required>
                </div>
                <div class="form-group">
                    <p class="white-text-color m-0" >Mot de Passe</p>
                    <input type="password" name="mdp" class="form-control second-main-background" style="outline: 0; border:0;" required>
                </div>
                <div class="d-flex form-group justify-content-center">
                    <button type="submit" class="font-size-20 main-color-background dark-text border-radius-5 padding-button font-weight-bold" style="outline: 0; border:0;">Se connecter</button>
                </div>
            </form>
            
            <a href="inscription.php" class="booki-link">Pas encore de Compte ?</a>
        </div>
    
HTML;


$webPage->appendContent($form);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();
