<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require "src/ViewLivre.php";
require "src/ViewResearchBook.php";
init_php_session();


$books = [];
$content = "";
$bookContent = "";
$paginator = "";


$research = <<<HTML
    <div class="header">
        <div class="d-flex flex-column dackdrop-blur h-100">
            $header
            <form class="d-flex justify-content-center flex-column flex-fill align-items-center" action="index.php" method="get">
                <span class="font-size-36 white-text-color">Rechercher</span>
                <div class="form-group research-button d-flex w-50">
                    <input type="text" name="research" class="research-button flex-fill white-background-color">
                </div>
                <div class="d-flex justify-content-start w-50">
                    <span class="font-size-24 white-text-color">Filtre(s) :</span>
                    <div class="border-radius-5 margin-left margin-right w-25 white-background-color"></div>
                    <div class="border-radius-5 margin-right flex-fill white-background-color"></div>
                    <div class="font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center">
                        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.027 22.896C11.323 22.896 10.731 22.672 10.251 22.224C9.803 21.744 9.579 21.152 9.579 20.448V14.016H3.147C2.443 14.016 1.851 13.776 1.371 13.296C0.923 12.816 0.699 12.224 0.699 11.52C0.699 10.816 0.923 10.24 1.371 9.792C1.851 9.312 2.443 9.072 3.147 9.072H9.579V2.64C9.579 1.968 9.819 1.392 10.299 0.912C10.811 0.431998 11.387 0.191998 12.027 0.191998C12.763 0.191998 13.355 0.431998 13.803 0.912C14.251 1.36 14.475 1.936 14.475 2.64V9.072H20.907C21.579 9.072 22.155 9.312 22.635 9.792C23.147 10.272 23.403 10.864 23.403 11.568C23.403 12.24 23.147 12.816 22.635 13.296C22.155 13.776 21.579 14.016 20.907 14.016H14.475V20.448C14.475 21.152 14.251 21.744 13.803 22.224C13.355 22.672 12.763 22.896 12.027 22.896Z" fill="#2F2F2F"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
    </div>
HTML;


// Contenue pour les livres //

$lesFavoris = Utilisateur::createFromId($_SESSION['idUtilisateur'])->getFavoris();

foreach ($lesFavoris as $livre){

    $bookContent .= printResearchBook($livre->getISBN());
}

// Paginateur //
/*
$query = $_GET;
$query['page']=$page-1;
$pred = http_build_query($query);
$query['page']=$page+1;
$next = http_build_query($query);
$query['page']=1;
$first = http_build_query($query);
$query['page']=intdiv($max, 30)+1;
$last = http_build_query($query);

$paginator .= <<<HTML
                <div class='d-flex main-background justify-content-between border-radius-100 w-75 m-4' style="padding-left: 10px; padding-right: 10px;">
                   <a class='font-size-20 p-2' href='{$_SERVER['PHP_SELF']}?$first'>
                       <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.3863 23.9998C10.7552 24.0006 10.1431 23.784 9.65295 23.3865L2.85295 17.7732C2.58629 17.5609 2.37094 17.2912 2.22293 16.9842C2.07491 16.6771 1.99805 16.3407 1.99805 15.9998C1.99805 15.659 2.07491 15.3226 2.22293 15.0155C2.37094 14.7085 2.58629 14.4388 2.85295 14.2265L9.65295 8.61318C10.0623 8.28517 10.5556 8.07876 11.0766 8.01747C11.5976 7.95618 12.1253 8.04247 12.5996 8.26651C13.0119 8.44822 13.3631 8.74475 13.6113 9.12067C13.8596 9.4966 13.9944 9.93604 13.9996 10.3865V21.6132C13.9944 22.0637 13.8596 22.5031 13.6113 22.879C13.3631 23.255 13.0119 23.5515 12.5996 23.7332C12.2185 23.9065 11.805 23.9974 11.3863 23.9998Z" fill="#D0D0D0"/>
                        <path d="M25.3882 24.0016C24.7572 24.0023 24.1451 23.7857 23.6549 23.3882L16.8549 17.7749C16.5882 17.5626 16.3729 17.2929 16.2249 16.9859C16.0769 16.6789 16 16.3424 16 16.0016C16 15.6607 16.0769 15.3243 16.2249 15.0172C16.3729 14.7102 16.5882 14.4405 16.8549 14.2282L23.6549 8.61489C24.0643 8.28688 24.5576 8.08047 25.0785 8.01918C25.5995 7.95789 26.1272 8.04418 26.6016 8.26822C27.0138 8.44993 27.365 8.74645 27.6133 9.12238C27.8615 9.49831 27.9963 9.93775 28.0016 10.3882V21.6149C27.9963 22.0654 27.8615 22.5048 27.6133 22.8807C27.365 23.2567 27.0138 23.5532 26.6016 23.7349C26.2204 23.9082 25.8069 23.9991 25.3882 24.0016Z" fill="#D0D0D0"/>
                        </svg>
                   </a>
                   <a class='font-size-20 no-decoration booki-link p-2' href='{$_SERVER['PHP_SELF']}?$pred'>Précédent</a>
                   <span class='font-size-20 main-text-color p-2'>$page</span>
                   <a class='font-size-20 no-decoration booki-link p-2' href='{$_SERVER['PHP_SELF']}?$next'>Suivant</a>
                   <a class='font-size-20 p-2' href='{$_SERVER['PHP_SELF']}?$last'>
                       <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <path d="M20.6137 8.00015C21.2448 7.9994 21.8569 8.21598 22.347 8.61348L29.147 14.2268C29.4137 14.4391 29.6291 14.7088 29.7771 15.0158C29.9251 15.3229 30.002 15.6593 30.002 16.0002C30.002 16.341 29.9251 16.6774 29.7771 16.9845C29.6291 17.2915 29.4137 17.5612 29.147 17.7735L22.347 23.3868C21.9377 23.7148 21.4444 23.9212 20.9234 23.9825C20.4024 24.0438 19.8747 23.9575 19.4004 23.7335C18.9881 23.5518 18.6369 23.2553 18.3887 22.8793C18.1404 22.5034 18.0056 22.064 18.0004 21.6135L18.0004 10.3868C18.0056 9.93635 18.1404 9.4969 18.3887 9.12098C18.6369 8.74505 18.9882 8.44853 19.4004 8.26682C19.7815 8.09349 20.195 8.00262 20.6137 8.00015Z" fill="#D0D0D0"/>
                       <path d="M6.61176 7.99844C7.24284 7.99769 7.85494 8.21427 8.3451 8.61177L15.1451 14.2251C15.4118 14.4374 15.6271 14.7071 15.7751 15.0141C15.9231 15.3211 16 15.6576 16 15.9984C16 16.3393 15.9231 16.6757 15.7751 16.9828C15.6271 17.2898 15.4118 17.5595 15.1451 17.7718L8.3451 23.3851C7.93572 23.7131 7.44243 23.9195 6.92145 23.9808C6.40047 24.0421 5.87275 23.9558 5.39843 23.7318C4.9862 23.5501 4.63498 23.2535 4.38673 22.8776C4.13847 22.5017 4.00367 22.0622 3.99843 21.6118L3.99843 10.3851C4.00367 9.93464 4.13847 9.49519 4.38673 9.11927C4.63498 8.74334 4.9862 8.44682 5.39843 8.26511C5.77959 8.09178 6.19305 8.00091 6.61176 7.99844Z" fill="#D0D0D0"/>
                       </svg>
                   </a>  
               </div>
HTML;
*/


$content .= <<<HTML
        <div class="container d-flex flex-column align-items-center">
            <div class="d-flex flex-wrap justify-content-center">
                $bookContent
            </div>
            $paginator
        </div>
HTML;

$webPage = new WebPage("Favoris");
$webPage->appendCssUrl("src/style.css");
$webPage->appendContent(getHeader());
$webPage->appendContent($research);
$webPage->appendContent($content);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();