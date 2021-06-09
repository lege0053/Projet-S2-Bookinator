<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require "src/ViewResearchBook.php";
init_php_session();

$authors = [];
$genres = [];
$years = [];
$editeurs = [];
$languages = [];
$research = "";
$filterId = 1;
$filterList = "";
$livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, 0);
$page = 1;
$booksContent = "";
$paginator = "";

if(isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page'])){
    if(!((int)($_GET['page']) <= 0)){
        $page = (int)($_GET['page']);
        $livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, $page-1);
    }
}

// Listes des Filtres ainsi que listes des livres à afficher //

if( (isset($_GET['author']) && !empty($_GET['author'])) || (isset($_GET['genre']) && !empty($_GET['genre']))
|| (isset($_GET['year']) && !empty($_GET['year'])) || (isset($_GET['editeur']) && !empty($_GET['editeur']))
|| (isset($_GET['langue']) && !empty($_GET['langue'])) || (isset($_GET['research']) && !empty($_GET['research']))) {
    if(isset($_GET['author']) && !empty($_GET['author'])){
        $authors = $_GET['author'];

        foreach($authors as $author){
            $value = $author;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Auteur</div> <input value='$value' type='text' name='author[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['genre']) && !empty($_GET['genre'])){
        $genres = $_GET['genre'];

        foreach($genres as $genre){
            $value = $genre;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Genre</div> <input value='$value' type='text' name='genre[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['year']) && !empty($_GET['year'])){
        $years = $_GET['year'];

        foreach($years as $year){
            $value = $year;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Année</div> <input value='$value' type='text' name='year[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['editeur']) && !empty($_GET['editeur'])){
        $editeurs = $_GET['editeur'];
        foreach($editeurs as $editeur){
            $value = $editeur;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Editeur</div> <input value='$value' type='text' name='editeur[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['langue']) && !empty($_GET['langue'])){
        $languages = $_GET['langue'];

        foreach($languages as $language){
            $value = $language;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Langue</div> <input value='$value' type='text' name='language[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['research']) && !empty($_GET['research'])){
        $research = $_GET['research'];
    }
    $livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, $page-1);

    if(count($livres) == 0){
        $livres = $livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, 0);
    }
}
$max = count($livres);

// Contenue pour les livres //

foreach ($livres as $livre){
    $booksContent .= printResearchBook($livre->getISBN());
}

// Paginateur //

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



$header = getIndexHeader();
$content = <<<HTML
    <div class="header">
        <div class="d-flex flex-column dackdrop-blur h-100">
            $header
            <form class="d-flex justify-content-center flex-column flex-fill align-items-center" action="index.php" method="get">
                <span class="font-size-36 white-text-color">Rechercher</span>
                <div class="form-group research-button d-flex w-50 white-background-color button-no-outline border-radius-100">
                    <button type="submit" class="button-no-outline bg-transparent margin-left">
                        <svg width="36" height="36" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.9461 3.64285C25.5353 3.64285 29.9366 5.4659 33.1816 8.71095C36.4267 11.956 38.2497 16.3572 38.2497 20.9464C38.2497 24.7386 37.0294 28.2449 34.962 31.0972L46.5573 42.6925C47.0586 43.1865 47.35 43.855 47.3706 44.5585C47.3912 45.2621 47.1395 45.9465 46.6679 46.469C46.1963 46.9915 45.5413 47.3119 44.8393 47.3634C44.1373 47.4148 43.4425 47.1933 42.8998 46.7451L42.6922 46.5575L31.097 34.9623C28.1466 37.1049 24.5924 38.256 20.9461 38.25C16.357 38.25 11.9557 36.4269 8.71068 33.1819C5.46563 29.9368 3.64258 25.5356 3.64258 20.9464C3.64258 16.3572 5.46563 11.956 8.71068 8.71095C11.9557 5.4659 16.357 3.64285 20.9461 3.64285ZM20.9461 9.10714C17.8062 9.10714 14.7948 10.3545 12.5745 12.5748C10.3542 14.7951 9.10686 17.8064 9.10686 20.9464C9.10686 24.0864 10.3542 27.0978 12.5745 29.3181C14.7948 31.5384 17.8062 32.7857 20.9461 32.7857C24.0861 32.7857 27.0975 31.5384 29.3178 29.3181C31.5381 27.0978 32.7854 24.0864 32.7854 20.9464C32.7854 17.8064 31.5381 14.7951 29.3178 12.5748C27.0975 10.3545 24.0861 9.10714 20.9461 9.10714Z" fill="#2F2F2F"/>
                        </svg>
                    </button>
                    <input type="text" name="research" class="flex-fill button-no-outline bg-transparent" value="$research">
                </div>
                <div class="d-flex justify-content-start w-50">
                    <span class="font-size-24 white-text-color">Filtre(s) :</span>
                    <div class="flex-fill">
                        <div class="d-flex flex-column flex-fill">
                            <div class="d-flex flex-fill">
                                <select id="filter-list" class="margin-left margin-right white-background-color flex-fill button-no-outline border-radius-5">
                                  <option value="author">Auteur</option>
                                  <option value="editeur">Editeur</option>
                                  <option value="genre">Genre</option>
                                  <option value="year">Année</option>
                                  <option value="language">Langue</option>
                                </select>
                                <div class="font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center" onclick="addFilter()">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" rx="5" fill="#E1B74A"/>
                                    <path d="M24.027 35.896C23.323 35.896 22.731 35.672 22.251 35.224C21.803 34.744 21.579 34.152 21.579 33.448V27.016H15.147C14.443 27.016 13.851 26.776 13.371 26.296C12.923 25.816 12.699 25.224 12.699 24.52C12.699 23.816 12.923 23.24 13.371 22.792C13.851 22.312 14.443 22.072 15.147 22.072H21.579V15.64C21.579 14.968 21.819 14.392 22.299 13.912C22.811 13.432 23.387 13.192 24.027 13.192C24.763 13.192 25.355 13.432 25.803 13.912C26.251 14.36 26.475 14.936 26.475 15.64V22.072H32.907C33.579 22.072 34.155 22.312 34.635 22.792C35.147 23.272 35.403 23.864 35.403 24.568C35.403 25.24 35.147 25.816 34.635 26.296C34.155 26.776 33.579 27.016 32.907 27.016H26.475V33.448C26.475 34.152 26.251 34.744 25.803 35.224C25.355 35.672 24.763 35.896 24.027 35.896Z" fill="#2F2F2F"/>
                                    </svg>
                                </div>
                            </div>
                            <div id="filters" class="d-flex flex-column flex-fill">
                                $filterList
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container d-flex flex-column align-items-center">
        <div class="d-flex flex-wrap justify-content-center">
            $booksContent
        </div>
        $paginator
    </div>
HTML;

$webPage = new WebPage("Bookinator");
$webPage->appendCssUrl("src/style.css");
$webPage->appendJsUrl("src/filters.js");
$webPage->appendContent($content);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();