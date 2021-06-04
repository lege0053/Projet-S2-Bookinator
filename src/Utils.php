<?php
declare(strict_types=1);

function init_php_session() : bool {
    if(!session_id()){
        session_start();
        session_regenerate_id();
        return true;
    }
    return false;
}

function end_php_session() : void
{
    session_start();
    session_reset();
    session_destroy();
}

function isLogged() : bool
{
    if(isset($_SESSION['idUtilisateur'])){
        return true;
    }
    return false;
}

function isAdmin() : bool
{
    if(isLogged() && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1)
        return true;
    return false;
}

function getIndexHeader() : String
{
    if(isLogged()) {

    }
    $header = <<<HTLM

    HTLM;
    return $header;

}

function getHeader() : String
{
    if(isLogged()) {

    }
    $header = <<<HTLM
        <div class="header d-flex main-background">
            <div class="navbar">
                <div class="font-size-24 white-text-color m-1"><img class="logo m-2" src="img/logo-48.png" width="48">Bookinator</div>
                <a class="main-color-background dark-text border-radius-5 p-2 font-weight-bold">Rechercher</a>
            </div>
        </div>
    HTLM;
    return $header;

}

function getFooter() : String
{
    $footer = <<<HTML
        <div class="footer d-flex flex-column align-items-center main-background">
            <div class="font-size-24 white-text-color m-1"><img class="logo m-2" src="img/logo-48.png" width="48">Bookinator</div>
            <span class="font-size-20 main-text-color m-3">&copy; 2021, Bookinator.fr - <a href="#" class="booki-link">Conditions Générales de vente</a></span>
        </div>
    HTML;
    return $footer;
}