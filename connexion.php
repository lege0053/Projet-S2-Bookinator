<?php
declare(strict_types=1);

require_once "autoload.php";
require_once "src/Utils.php";
init_php_session();

$webPage = new WebPage("Connexion");

$form = <<<HTML

    <div class="login-form">
    
        <form action="connexion_trmt.php" method="post">
            <h2 class="form-title">Se Connecter</h2>
            <div class="form-group">
                <input type="email" name="mail" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
            </div>
            <div class="form-group">
                <button type="submit" class="form_submit">Connexion</button>
            </div>
        </form>
        
        <p class="form_other_p"><a href="inscription.php">Pas encore de Compte ?</a></p>
    
    </div>
HTML;


$webPage->appendContent($form);

echo $webPage->toHTML();