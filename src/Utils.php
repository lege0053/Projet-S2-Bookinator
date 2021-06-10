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
    $header = <<<HTML
        <div class="d-flex align-items-center p-1 justify-content-between">
            <div class="d-flex align-items-center">
                <a href="index.php" class="font-size-24 white-text-color m-1 no-decoration"><img class="logo m-2" src="img/logo-48.png" width="48">Bookinator</a>
             </div>
    HTML;
    if(isLogged()) {
        $header .= <<<HTML
           <div class="d-flex align-items-center">
                <a href="panier.php" class="panier-button border-radius-5 main-color-background button">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.02148 30.625C6.88398 30.625 5.89232 29.9687 5.41107 29.0208L1.60482 15.225L1.45898 14.5833C1.45898 14.1966 1.61263 13.8256 1.88612 13.5521C2.15961 13.2786 2.53054 13.125 2.91732 13.125H9.59648L16.3048 3.54375C16.4393 3.34815 16.6196 3.18844 16.83 3.07857C17.0404 2.9687 17.2745 2.91201 17.5118 2.91345C17.7492 2.91489 17.9825 2.97441 18.1916 3.08682C18.4006 3.19924 18.579 3.36112 18.7111 3.55833L25.4048 13.125H32.084C32.4708 13.125 32.8417 13.2786 33.1152 13.5521C33.3887 13.8256 33.5423 14.1966 33.5423 14.5833L33.484 15.0063L29.5902 29.0208C29.109 29.9687 28.1173 30.625 26.9798 30.625H8.02148ZM17.5007 6.9125L13.1257 13.125H21.8757L17.5007 6.9125ZM17.5007 18.9583C16.7271 18.9583 15.9852 19.2656 15.4383 19.8126C14.8913 20.3596 14.584 21.1015 14.584 21.875C14.584 22.6485 14.8913 23.3904 15.4383 23.9374C15.9852 24.4844 16.7271 24.7917 17.5007 24.7917C18.2742 24.7917 19.0161 24.4844 19.563 23.9374C20.11 23.3904 20.4173 22.6485 20.4173 21.875C20.4173 21.1015 20.11 20.3596 19.563 19.8126C19.0161 19.2656 18.2742 18.9583 17.5007 18.9583Z" fill="#2F2F2F"/>
                    </svg>
                </a>
                <a href="userpage.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Profil</a>
        HTML;
        if(isAdmin()) {
            $header .= <<<HTML
                    <a href="gestionLivre.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Espace Admin</a>
            HTML;
        }
        $header .= <<<HTML
                    </div>
                </div>
        HTML;
    }
    else {
        $header .= <<<HTML
            <div class="d-flex align-items-center">
                <a href="panier.php" class="panier-button border-radius-5 main-color-background button">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.02148 30.625C6.88398 30.625 5.89232 29.9687 5.41107 29.0208L1.60482 15.225L1.45898 14.5833C1.45898 14.1966 1.61263 13.8256 1.88612 13.5521C2.15961 13.2786 2.53054 13.125 2.91732 13.125H9.59648L16.3048 3.54375C16.4393 3.34815 16.6196 3.18844 16.83 3.07857C17.0404 2.9687 17.2745 2.91201 17.5118 2.91345C17.7492 2.91489 17.9825 2.97441 18.1916 3.08682C18.4006 3.19924 18.579 3.36112 18.7111 3.55833L25.4048 13.125H32.084C32.4708 13.125 32.8417 13.2786 33.1152 13.5521C33.3887 13.8256 33.5423 14.1966 33.5423 14.5833L33.484 15.0063L29.5902 29.0208C29.109 29.9687 28.1173 30.625 26.9798 30.625H8.02148ZM17.5007 6.9125L13.1257 13.125H21.8757L17.5007 6.9125ZM17.5007 18.9583C16.7271 18.9583 15.9852 19.2656 15.4383 19.8126C14.8913 20.3596 14.584 21.1015 14.584 21.875C14.584 22.6485 14.8913 23.3904 15.4383 23.9374C15.9852 24.4844 16.7271 24.7917 17.5007 24.7917C18.2742 24.7917 19.0161 24.4844 19.563 23.9374C20.11 23.3904 20.4173 22.6485 20.4173 21.875C20.4173 21.1015 20.11 20.3596 19.563 19.8126C19.0161 19.2656 18.2742 18.9583 17.5007 18.9583Z" fill="#2F2F2F"/>
                    </svg>
                </a>
                <a href="connexion.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Connexion</a>
                <a href="inscription.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Inscription</a>
            </div>
        </div>
    HTML;
    }
    return $header;

}

function getHeader() : String
{
    $header = <<<HTML
        <div class="d-flex main-background align-items-center p-1 justify-content-between">
            <div class="d-flex align-items-center">
                <a href="index.php" class="font-size-24 white-text-color m-1 no-decoration"><img class="logo m-2" src="img/logo-48.png" width="48">Bookinator</a>
                <a href="index.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Rechercher</a>
            </div>
    HTML;
    if(isLogged()) {
        $header .= <<<HTML
           <div class="d-flex align-items-center">
                <a href="panier.php" class="panier-button border-radius-5 main-color-background button">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.02148 30.625C6.88398 30.625 5.89232 29.9687 5.41107 29.0208L1.60482 15.225L1.45898 14.5833C1.45898 14.1966 1.61263 13.8256 1.88612 13.5521C2.15961 13.2786 2.53054 13.125 2.91732 13.125H9.59648L16.3048 3.54375C16.4393 3.34815 16.6196 3.18844 16.83 3.07857C17.0404 2.9687 17.2745 2.91201 17.5118 2.91345C17.7492 2.91489 17.9825 2.97441 18.1916 3.08682C18.4006 3.19924 18.579 3.36112 18.7111 3.55833L25.4048 13.125H32.084C32.4708 13.125 32.8417 13.2786 33.1152 13.5521C33.3887 13.8256 33.5423 14.1966 33.5423 14.5833L33.484 15.0063L29.5902 29.0208C29.109 29.9687 28.1173 30.625 26.9798 30.625H8.02148ZM17.5007 6.9125L13.1257 13.125H21.8757L17.5007 6.9125ZM17.5007 18.9583C16.7271 18.9583 15.9852 19.2656 15.4383 19.8126C14.8913 20.3596 14.584 21.1015 14.584 21.875C14.584 22.6485 14.8913 23.3904 15.4383 23.9374C15.9852 24.4844 16.7271 24.7917 17.5007 24.7917C18.2742 24.7917 19.0161 24.4844 19.563 23.9374C20.11 23.3904 20.4173 22.6485 20.4173 21.875C20.4173 21.1015 20.11 20.3596 19.563 19.8126C19.0161 19.2656 18.2742 18.9583 17.5007 18.9583Z" fill="#2F2F2F"/>
                    </svg>
                </a>
                <a href="userpage.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Profil</a>
        HTML;
        if(isAdmin()) {
            $header .= <<<HTML
                    <a href="gestionLivre.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Espace Admin</a>
            HTML;
        }
        $header .= <<<HTML
                    </div>
                </div>
        HTML;
    }
    else {
        $header .= <<<HTLM
            <div class="d-flex align-items-center">
                <a href="panier.php" class="panier-button border-radius-5 main-color-background button">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.02148 30.625C6.88398 30.625 5.89232 29.9687 5.41107 29.0208L1.60482 15.225L1.45898 14.5833C1.45898 14.1966 1.61263 13.8256 1.88612 13.5521C2.15961 13.2786 2.53054 13.125 2.91732 13.125H9.59648L16.3048 3.54375C16.4393 3.34815 16.6196 3.18844 16.83 3.07857C17.0404 2.9687 17.2745 2.91201 17.5118 2.91345C17.7492 2.91489 17.9825 2.97441 18.1916 3.08682C18.4006 3.19924 18.579 3.36112 18.7111 3.55833L25.4048 13.125H32.084C32.4708 13.125 32.8417 13.2786 33.1152 13.5521C33.3887 13.8256 33.5423 14.1966 33.5423 14.5833L33.484 15.0063L29.5902 29.0208C29.109 29.9687 28.1173 30.625 26.9798 30.625H8.02148ZM17.5007 6.9125L13.1257 13.125H21.8757L17.5007 6.9125ZM17.5007 18.9583C16.7271 18.9583 15.9852 19.2656 15.4383 19.8126C14.8913 20.3596 14.584 21.1015 14.584 21.875C14.584 22.6485 14.8913 23.3904 15.4383 23.9374C15.9852 24.4844 16.7271 24.7917 17.5007 24.7917C18.2742 24.7917 19.0161 24.4844 19.563 23.9374C20.11 23.3904 20.4173 22.6485 20.4173 21.875C20.4173 21.1015 20.11 20.3596 19.563 19.8126C19.0161 19.2656 18.2742 18.9583 17.5007 18.9583Z" fill="#2F2F2F"/>
                    </svg>
                </a>
                <a href="connexion.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Connexion</a>
                <a href="inscription.php" class="font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">Inscription</a>
            </div>
        </div>
        HTLM;
    }
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