<?php
declare(strict_types=1);

function affichageLivre(string $isbn):string
{
    $livre=Livre::createFromId($isbn);


    $listeAuteur=$livre->getAuteurs();
    $nomsAuteurs='';
    for($i=0; $i<count($listeAuteur);$i++)
    {
        $nomsAuteurs.="<a href='index.php?author[]={$listeAuteur[$i]->getNom()}' class='booki-link'>{$listeAuteur[$i]->getPrnm()} {$listeAuteur[$i]->getNom()}</a>";
        if($i!=count($listeAuteur)-1 && count($listeAuteur)!=1)
            $nomsAuteurs.=", ";
    }


    $listeGenre=$livre->getGenres();
    $nomsGenres='';
    for($i=0; $i<count($listeGenre);$i++)
    {
        $nomsGenres.="<a href='index.php?genre[]={$listeGenre[$i]->getLibGenre()}' class='booki-link'>{$listeGenre[$i]->getLibGenre()}</a>";
        if($i!=count($listeGenre)-1 && count($listeGenre)!=1)
            $nomsGenres.=", ";
    }


    $editeur=Editeur::createFromId($livre->getIdEditeur())->getLibEditeur();

    $favori='<td></td>';
    if(isLogged())
    {
        $favori="<td class='d-flex flex-row'>
<a href='trmt/addFavoris_trmt.php?isbn=$isbn' class='d-flex justify-content-center align-items-center font-size-24 border-radius-5 padding-button button'>
    <svg width='50' height='50' viewBox='0 0 88 88' fill='none' xmlns='http://www.w3.org/2000/svg'>
        <rect width='88' height='88' rx='5' fill='#E1B74A'/>
        <path d='M64.5137 25.9775C63.1352 24.5893 61.4959 23.4872 59.6901 22.7347C57.8843 21.9822 55.9475 21.594 53.9912 21.5925C50.2907 21.5931 46.7254 22.9832 44.0012 25.4875C41.2772 22.9827 37.7117 21.5926 34.0112 21.5925C32.0525 21.5945 30.1136 21.9839 28.306 22.7382C26.4984 23.4924 24.8578 24.5967 23.4787 25.9875C17.5962 31.895 17.5987 41.135 23.4837 47.0175L44.0012 67.535L64.5187 47.0175C70.4037 41.135 70.4062 31.895 64.5137 25.9775Z' fill='#2F2F2F'/>
    </svg>
</a>
<a href='addSignalement.php?isbn=$isbn' class='d-flex justify-content-center align-items-center'><svg width='28' height='28' viewBox='0 0 28 28' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M21.7543 2.34259C18.8115 0.38662 15.2787 -0.38085 11.7948 0.177827C11.7341 0.178975 11.6735 0.184827 11.6128 0.195326C7.9295 0.834447 4.71503 2.86977 2.56077 5.92559C0.408855 8.98261 -0.425114 12.6939 0.212913 16.3785C0.319059 16.9861 0.46715 17.5985 0.653795 18.1933C1.42476 20.6974 1.23462 23.3812 0.119618 25.7501C-0.0751751 26.1606 -0.0110279 26.6482 0.281763 26.9969C0.5745 27.3457 1.03873 27.4903 1.48191 27.3713L6.71065 25.9437C8.92441 27.299 11.4238 28 13.9758 28C14.9031 28 15.8373 27.9078 16.7669 27.72C20.4328 26.9817 23.5913 24.8613 25.6604 21.7483C29.9327 15.3218 28.1809 6.61726 21.7543 2.34259ZM23.7184 20.4572C21.9934 23.0523 19.3609 24.8194 16.3074 25.434C13.2562 26.0487 10.1444 25.4375 7.54811 23.7114C7.35452 23.5831 7.12938 23.5166 6.90194 23.5166C6.79929 23.5166 6.6955 23.5306 6.594 23.5586L3.0343 24.5301C3.63497 22.2371 3.59062 19.8087 2.8815 17.5005C2.72406 16.9978 2.59926 16.4858 2.51177 15.9796C1.97989 12.9098 2.67506 9.81658 4.46888 7.26923C6.23241 4.76509 8.85085 3.08436 11.8566 2.52333C11.9126 2.52098 11.9674 2.51518 12.0234 2.50583C14.9731 1.99615 17.9706 2.62947 20.4643 4.28685C25.8202 7.84776 27.2792 15.1013 23.7184 20.4572Z' fill='#E2574C'/>
                        <path d='M14.0042 6.8855C13.3593 6.8855 12.8379 7.40688 12.8379 8.05185V15.05C12.8379 15.6949 13.3593 16.2163 14.0042 16.2163C14.6492 16.2163 15.1706 15.6938 15.1706 15.05V8.05185C15.1706 7.40688 14.6493 6.8855 14.0042 6.8855Z' fill='#E2574C'/>
                        <path d='M15.0761 19.3876C15.0178 19.236 14.9362 19.1077 14.8312 19.0028C14.7729 18.9561 14.7145 18.8978 14.6446 18.8628C14.5863 18.8162 14.5163 18.7823 14.4463 18.7578C14.3763 18.7217 14.3063 18.6995 14.2247 18.6878C13.8526 18.6062 13.4432 18.7356 13.1761 19.0028C13.0711 19.1077 12.9895 19.2361 12.9312 19.3876C12.8729 19.5276 12.8379 19.6792 12.8379 19.8309C12.8379 19.9825 12.8729 20.1341 12.9312 20.2741C12.9895 20.4141 13.0711 20.5423 13.1761 20.659C13.2928 20.7639 13.4211 20.8456 13.561 20.9039C13.701 20.9622 13.8526 20.9972 14.0042 20.9972C14.1559 20.9972 14.3063 20.9622 14.4463 20.9039C14.5862 20.8456 14.7134 20.764 14.8312 20.659C14.9362 20.5423 15.0177 20.4141 15.0761 20.2741C15.1344 20.1342 15.1694 19.9825 15.1694 19.8309C15.1694 19.6792 15.1344 19.5276 15.0761 19.3876Z' fill='#E2574C'/>
                       </svg><a>
</td>";
    }




    $retour="
<div class='d-flex flex-column-reverse flex-md-row font-size-24 align-items-center justify-content-md-center p-5'>
    <div class='m-1 d-flex flex-column w-75'>
        <div class='d-flex flex-row justify-content-between'>
            <span class='mb-4 font-size-28'>{$livre->getTitre()}</span>";

    if($livre->getNoteMoyenne()!=-1)
        $retour.="
            <a href='#avis' class='booki-link'>({$livre->getNbAppreciations()} avis) {$livre->getNoteMoyenne()}/5</a>";
    else
        $retour.="
            <span class='booki-link font-size-20'>({$livre->getNbAppreciations()} avis) Aucune note</span>";

    $retour.="
        </div>
        <table>
            <tr>
                <td>Prix</td>
                <td class='main-text-color font-size-20'>{$livre->getPrix()} €</td>
             
            </tr>
            <tr>
                <td>Éditeur</td>
                <td><a href='index.php?editeur[]=$editeur' class='booki-link font-size-20'>$editeur</a></td>
            </tr>
            <tr>
                <td>Auteur</td>
                <td class='font-size-20'>$nomsAuteurs</td>            
            </tr>
            <tr>
                <td>Année de publication</td>
                <td><a href='index.php?year[]={$livre->getDatePublication()}'  class='booki-link font-size-20'>{$livre->getDatePublication()}</a></td>               
            </tr>
            <tr>
                <td>Genre</td>
                <td class='font-size-20'>$nomsGenres</td>                
            </tr>
            <tr>
               <td>Langue</td>
               <td><a href='index.php?langue[]={$livre->getLangue()}' class='booki-link font-size-20'>{$livre->getLangue()}</a></td>               
            </tr>
            <tr>
                <td>ISBN</td>
                <td class='booki-link font-size-20'>{$livre->getISBN()}</td>
                $favori
            </tr>
        </table>
        <span class='mt-4 mb-2'>Description :</span>
        <span class='p-3 border-radius-10 description-background description-text font-size-20'>{$livre->getDescription()}</span>
    </div>
    <img alt='' src='./src/ViewCouverture.php?id={$livre->getIdCouv()}' height='560' class='p-2'>
</div>
";
    return $retour;
}

function affichageAppreciations(string $isbn):string
{
    $livre=Livre::createFromId($isbn);
    $listeAppreciations=$livre->getAppreciations();
    $retour="<div id='avis' class='d-flex flex-column'>";


    foreach ($listeAppreciations as $elmt)
    {
        $utilisateur=Utilisateur::createFromId($elmt->getIdUtilisateur());

        if($utilisateur->getPhotoProfil() == null)
        {
            $pdp= <<<HTML
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="30" cy="30" r="30" fill="#525252"/>
                    <path d="M37.9744 24.3122H34.9384V24.0003C34.9384 22.6068 33.8074 21.4759 32.4139 21.4759H27.5855C26.1915 21.4759 25.0611 22.6068 25.0611 24.0003V24.3122H22.0244C20.6304 24.3122 19.5 25.4426 19.5 26.8367V35.9999C19.5 37.3933 20.6304 38.5243 22.0244 38.5243H37.9756C39.3696 38.5243 40.5 37.3933 40.5 35.9999V26.8367C40.4989 25.4421 39.3685 24.3122 37.9744 24.3122ZM29.9989 35.9056C27.369 35.9056 25.2305 33.7671 25.2305 31.1372C25.2305 28.5079 27.369 26.3688 29.9989 26.3688C32.6288 26.3688 34.7673 28.5073 34.7673 31.1372C34.7673 33.7671 32.6282 35.9056 29.9989 35.9056ZM32.5233 31.1372C32.5233 32.5279 31.3901 33.6617 29.9989 33.6617C28.6076 33.6617 27.4744 32.5279 27.4744 31.1372C27.4744 29.746 28.6076 28.6128 29.9989 28.6128C31.3901 28.6128 32.5233 29.746 32.5233 31.1372Z" fill="#353535"/>
                </svg>
            HTML;
        } else {
            $pdp = <<<HTML
                <img alt="" src="./src/ViewPdP.php?id={$utilisateur->getIdUtilisateur()}" height="50" width="50" class="border-radius-100">
            HTML;
        }

        $userPseudo=$utilisateur->getPseudo();
        if($userPseudo==null)
            $userPseudo=$utilisateur->getNom()." ".$utilisateur->getPrenom();
        $retour.="
<div class='mb-5 p-4 d-flex flex-column font-size-24 border-radius-10 main-background w-75 align-self-center'>
    <div class='d-flex flex-row justify-content-between'>
        <div>
            $pdp
            <span class='white-text-color'>$userPseudo</span>
        </div>
        <span class='booki-link'>{$elmt->getNote()}</span>
    </div>
    <textarea class='p-3 d-flex border-radius-5 second-main-background font-size-20 white-text-color' cols='300' rows='6' style='margin-top: 10px; resize: none;' disabled>{$elmt->getCommentaire()}</textarea>";
        if(isLogged())
        {
            $retour.="<a href='addSignalement.php?idApp={$elmt->getIdAppreciation()}' style='margin-top: 10px;'><svg width='28' height='28' viewBox='0 0 28 28' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M21.7543 2.34259C18.8115 0.38662 15.2787 -0.38085 11.7948 0.177827C11.7341 0.178975 11.6735 0.184827 11.6128 0.195326C7.9295 0.834447 4.71503 2.86977 2.56077 5.92559C0.408855 8.98261 -0.425114 12.6939 0.212913 16.3785C0.319059 16.9861 0.46715 17.5985 0.653795 18.1933C1.42476 20.6974 1.23462 23.3812 0.119618 25.7501C-0.0751751 26.1606 -0.0110279 26.6482 0.281763 26.9969C0.5745 27.3457 1.03873 27.4903 1.48191 27.3713L6.71065 25.9437C8.92441 27.299 11.4238 28 13.9758 28C14.9031 28 15.8373 27.9078 16.7669 27.72C20.4328 26.9817 23.5913 24.8613 25.6604 21.7483C29.9327 15.3218 28.1809 6.61726 21.7543 2.34259ZM23.7184 20.4572C21.9934 23.0523 19.3609 24.8194 16.3074 25.434C13.2562 26.0487 10.1444 25.4375 7.54811 23.7114C7.35452 23.5831 7.12938 23.5166 6.90194 23.5166C6.79929 23.5166 6.6955 23.5306 6.594 23.5586L3.0343 24.5301C3.63497 22.2371 3.59062 19.8087 2.8815 17.5005C2.72406 16.9978 2.59926 16.4858 2.51177 15.9796C1.97989 12.9098 2.67506 9.81658 4.46888 7.26923C6.23241 4.76509 8.85085 3.08436 11.8566 2.52333C11.9126 2.52098 11.9674 2.51518 12.0234 2.50583C14.9731 1.99615 17.9706 2.62947 20.4643 4.28685C25.8202 7.84776 27.2792 15.1013 23.7184 20.4572Z' fill='#E2574C'/>
                        <path d='M14.0042 6.8855C13.3593 6.8855 12.8379 7.40688 12.8379 8.05185V15.05C12.8379 15.6949 13.3593 16.2163 14.0042 16.2163C14.6492 16.2163 15.1706 15.6938 15.1706 15.05V8.05185C15.1706 7.40688 14.6493 6.8855 14.0042 6.8855Z' fill='#E2574C'/>
                        <path d='M15.0761 19.3876C15.0178 19.236 14.9362 19.1077 14.8312 19.0028C14.7729 18.9561 14.7145 18.8978 14.6446 18.8628C14.5863 18.8162 14.5163 18.7823 14.4463 18.7578C14.3763 18.7217 14.3063 18.6995 14.2247 18.6878C13.8526 18.6062 13.4432 18.7356 13.1761 19.0028C13.0711 19.1077 12.9895 19.2361 12.9312 19.3876C12.8729 19.5276 12.8379 19.6792 12.8379 19.8309C12.8379 19.9825 12.8729 20.1341 12.9312 20.2741C12.9895 20.4141 13.0711 20.5423 13.1761 20.659C13.2928 20.7639 13.4211 20.8456 13.561 20.9039C13.701 20.9622 13.8526 20.9972 14.0042 20.9972C14.1559 20.9972 14.3063 20.9622 14.4463 20.9039C14.5862 20.8456 14.7134 20.764 14.8312 20.659C14.9362 20.5423 15.0177 20.4141 15.0761 20.2741C15.1344 20.1342 15.1694 19.9825 15.1694 19.8309C15.1694 19.6792 15.1344 19.5276 15.0761 19.3876Z' fill='#E2574C'/>
                       </svg><a>";
        }
    }
    $retour.="</div></div>";

    return $retour;
}

function affichageConnecte(string $isbn):string
{
    $retour="
    <div class='d-flex justify-content-center'>
        <div class ='d-flex flex-column flex-md-row w-75 pb-4'>
            <a href='addToPanier.php?id=$isbn' class='justify-content-center d-flex flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button'>Ajouter au panier</a>";

    if(Appreciation::exist($isbn, $_SESSION['idUtilisateur']))
    {
        $retour.="<a href='' class='justify-content-center d-flex flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button'>Merci de votre retour !</a>";
    }
    else
    {
        $retour.="<a href='addCommentaire.php?id=$isbn' class='justify-content-center d-flex flex-md-grow-1 font-size-24 main-color-background dark-text border-radius-5 padding-button font-weight-bold button'>Rédiger une appréciation</a>";
    }
    $retour.="                               
        </div>
    </div>
    ";
    return $retour;
}