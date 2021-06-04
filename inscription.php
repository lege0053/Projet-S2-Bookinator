<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
init_php_session();

$webPage = new WebPage("Inscription");

$form = <<<HTML

    <div class="login-form">
    
        <form action="inscription_trmt.php" method="post">
            <h2 class="form-title">S'Inscrire</h2>
            <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <input type="text" name="prnm" class="form-control" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <input type="email" name="mail" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="email" name="repeat_mail" class="form-control" placeholder="Retapez votre Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <input type="password" name="repeat_mdp" class="form-control" placeholder="Retapez votre Mot de passe" required>
            </div>
            <div class="form-group">
                <input type="date" name="dateNais" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="form_submit">Inscription</button>
            </div>
        </form>
    
    </div>
HTML;


$webPage->appendContent($form);

echo $webPage->toHTML();