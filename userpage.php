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

$html = <<<HTML
    <div class="d-flex flex-row-3">
        <div class="d-flex align-items-start">
            <a href="index.php" class="d-flex main-color-background dark-text border-radius-100 padding-button font-weight-bold button">
                <svg width="52" height="43" viewBox="0 0 52 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 15.6667H36.2667C39.3785 15.6667 42.363 16.8958 44.5634 19.0838C46.7638 21.2717 48 24.2391 48 27.3333C48 30.4275 46.7638 33.395 44.5634 35.5829C42.363 37.7708 39.3785 39 36.2667 39H33.3333M15.7333 27.3333L4 15.6667L15.7333 4V27.3333Z" stroke="#2F2F2F" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        <div class="d-flex flex-column">
            <div class="d-flex flex-row">
                <div class="d-flex border-radius-100">
                    <img alt="" src="./src/ViewPdP.php?id={$user->getIdUtilisateur()}" height="300" width="418">
                </div>
                <div class=" d-flex font-size-20 main-color-background dark-text border-radius-5 padding-button font-weight-bold">Profil</div>
            </div>
            <div class="d-flex flex-row">
                <a href="favoris.php" class="font-size-20 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Mes Favoris</a>
                <form action="disconnect.php" method="post">
                    <button type="submit" class="btn font-size-20 bg-danger dark-text border-radius-5 padding-button font-weight-bold button">Se déconnecter</button>
                </form>
            </div>
            <div class="profil-form">
   
                <form action="profil_trmt.php" method="post">
                    <div class="form-group">
                    Nom <br>
                        <input type="text" name="nom" class="form-control" value="{$user->getNom()}" required>
                    </div>
                    <div class="form-group">
                    Prénom <br>
                        <input type="text" name="prnm" class="form-control" value="{$user->getPrenom()}" required>
                    </div>
                    <div class="form-group">
                    Adresse Mail <br>
                        <input type="email" name="mail" class="form-control" value="{$user->getMail()}" required>
                    </div>
                    <div class="form-group">
                    Confirmation Adresse Mail <br>
                        <input type="email" name="repeat_mail" class="form-control" value="{$user->getMail()}" required>
                    </div>
                    <div class="form-group">
                    Ville <br>
                        <input type="text" name="ville" class="form-control" value="{$user->getVille()}">
                    </div>
                    <div class="form-group">
                    Code postal <br>
                        <input type="text" name="CP" class="form-control" value="{$user->getCP()}">
                    </div>
                    <div class="form-group">
                    Adresse <br>
                        <input type="text" name="Adresse" class="form-control" value="{$user->getRue()}">
                    </div>
                    <div class="form-group">
                    Numéro Téléphone <br>
                        <input type="number" name="Tel" class="form-control" value="{$user->getTel()}">
                    </div>
                    <div class="form-group">
                    Modifier le mot de passe <br>
                        <input type="text" name="Adresse" class="form-control" value="*******">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form_submit font-size-20 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Sauvegarder</button>
                    </div>
                </form>
             </div>
         </div>
    </div>

HTML;

$webPage->appendContent($html);
$webPage->appendContent(getFooter());
echo $webPage->toHTML();


