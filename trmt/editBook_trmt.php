<?php
declare(strict_types=1);

require '../autoload.php';
require '../src/Utils.php';

init_php_session();

if(!isLogged()){
    header('Location: index.php');
}
if(!isAdmin()){
    header('Location: index.php');
}

$oldISBN = $_GET['oldISBN'];
$isbn = $_POST['isbn'];
$titre = $_POST['titre'];
$prix = $_POST['prix'];
$nbPages = $_POST['nbPages'];
$editeur = $_POST['editeur'];
$nomAuteurList = $_POST['nomAuteur'];
$prenomAuteurList = $_POST['prenomAuteur'];
$datePublication = $_POST['datePublication'];
$genreList = $_POST['genre'];
$langue = $_POST['langue'];
$description = $_POST['description'];
$idFormat = $_POST['format'];
$idSupport = $_POST['support'];
$qte = $_POST['qte'];

$mypdo = MyPDO::getInstance();

$authorId = [];
$genreId = [];
$editeurId = 1;
$couvertureId = 1;
$oldIdCouv = -1;

// Auteur : Si il n'existe pas, on l'ajoute ! Et on récupère son id //
$req = $mypdo->prepare(<<<SQL
    SELECT ISBN FROM Livre
    WHERE UPPER(ISBN) = UPPER(?)
SQL);
$req->execute([$oldISBN]);
$exist = $req->fetch();

if($exist) {
    for($i = 0; $i < count($nomAuteurList); $i++)
    {
        $req = $mypdo->prepare(<<<SQL
        SELECT idAuteur FROM Auteur
        WHERE UPPER(nom) = UPPER(?)
        AND UPPER(prnm) = UPPER(?)
        SQL);
        $req->execute([$nomAuteurList[$i], $prenomAuteurList[$i]]);
        $idExist = $req->fetch();
        if (!$idExist) {
            $addAuthor = $mypdo->prepare(<<<SQL
            INSERT INTO Auteur(nom, prnm, dateNais)
            VALUES(?,?, '1980-01-01')
            SQL);

            $addAuthor->execute([$nomAuteurList[$i], $prenomAuteurList[$i]]);

            $req = $mypdo->prepare(<<<SQL
            SELECT idAuteur FROM Auteur
            WHERE UPPER(nom) = UPPER(?)
            AND UPPER(prnm) = UPPER(?)
            SQL);
            $req->execute([$nomAuteurList[$i], $prenomAuteurList[$i]]);
            $authorId[] = $idExist['idAuteur'];
        }else{
            $authorId[] = $idExist['idAuteur'];
        }
    }


    // Editeur : Si il n'existe pas, on l'ajoute ! Et on récupère son id //

    $req = $mypdo->prepare(<<<SQL
        SELECT idEditeur FROM Editeur
        WHERE UPPER(libEditeur) = UPPER(?)
    SQL
    );
    $req->execute([$editeur]);
    $editeurId = $req->fetch();
    if (!$editeurId) {
        $addEditeur = $mypdo->prepare(<<<SQL
            INSERT INTO Editeur(libEditeur)
            VALUES(?)
        SQL
        );
        $addEditeur->execute([$editeur]);

        $req = $mypdo->prepare(<<<SQL
        SELECT idEditeur FROM Editeur
        WHERE UPPER(libEditeur) = UPPER(?)
        SQL
        );
        $req->execute([$editeur]);
        $editeurId = $req->fetch();
    }

    // Ajout de la Couverture //
    if(!empty($_FILES['couverture']['tmp_name']))
    {
        $reqCouv = $mypdo->prepare(<<<SQL
            SELECT idCouv FROM Livre WHERE ISBN = ? 
        SQL);
        $reqCouv->execute([$oldISBN]);
        $oldIdCouv = $reqCouv->fetch()['idCouv'];

        $image = $_FILES['couverture']['tmp_name'];
        $data = fopen($image, 'rb');
        $size = $_FILES['couverture']['size'];
        $contents = fread($data, $size);
        fclose($data);

        $addCouverture = $mypdo->prepare(<<<SQL
        INSERT INTO Couverture(png)
        VALUES(?)
        SQL);
        $addCouverture->execute([$contents]);
        $couvertureId = $mypdo->lastInsertId();
    }else{
        $couvertureId = Livre::createFromId($oldISBN)->getIdCouv();
    }

    // Delete Ecrire

    $reqDelEcrire = $mypdo->prepare(<<<SQL
        DELETE FROM Ecrire
        WHERE ISBN = ?
    SQL);
    $reqDelEcrire->execute([$oldISBN]);

    // Delete AvoirGenre

    $reqDelAvoirGenre = $mypdo->prepare(<<<SQL
        DELETE FROM AvoirGenre
        WHERE ISBN = ?
    SQL);
    $reqDelAvoirGenre->execute([$oldISBN]);

    // Favoris

    $reqSelectFavoris = $mypdo->prepare(<<<SQL
        SELECT idUtilisateur FROM Favoris
        WHERE ISBN = ?
    SQL);
    $reqSelectFavoris->execute([$oldISBN]);
    $favorisId = $reqSelectFavoris->fetchAll();

    $reqDelFavoris = $mypdo->prepare(<<<SQL
        DELETE FROM Favoris
        WHERE ISBN = ?
    SQL);
    $reqDelFavoris->execute([$oldISBN]);

    // Signalement Livre

    $reqSignalementLivre = $mypdo->prepare(<<<SQL
        SELECT idSignalement FROM SignalementLivre
        WHERE ISBN = ?
    SQL);
    $reqSignalementLivre->execute([$oldISBN]);
    $signalementsId = $reqSignalementLivre->fetchAll();

    $reqDelSignalementLivre = $mypdo->prepare(<<<SQL
        DELETE FROM SignalementLivre
        WHERE ISBN = ?
    SQL);
    $reqDelSignalementLivre->execute([$oldISBN]);

    // Ajout du Livre //

    $addLivre = $mypdo->prepare(<<<SQL
        UPDATE Livre
        SET ISBN = ?,
            titre = ?,
            datePublication = ?,
            nbPages = ?,
            langue = ?,
            description = ?,
            prix = ?,
            qte = ?,
            idEditeur = ?,
            idCouv = ?,
            idFormat = ?,
            idSupport = ?
        WHERE ISBN = ?
    SQL);
    $addLivre->execute([$isbn, $titre, $datePublication, $nbPages, $langue, $description, $prix, $qte, $editeurId['idEditeur'], $couvertureId, $idFormat, $idSupport, $oldISBN]);

    // Rajout Favoris //

    foreach($favorisId as $favo){
        $reqAddFavoris = $mypdo->prepare(<<<SQL
        INSERT INTO Favoris(idUtilisateur, ISBN)
        VALUES(?, ?)
        SQL);
        $reqAddFavoris->execute([$favo['idUtilisateur'], $isbn]);
    }

    // Rajout des Signalement

    foreach($signalementsId as $signalement){
        $reqAddSignalement = $mypdo->prepare(<<<SQL
        INSERT INTO SignalementLivre(idUtilisateur, ISBN)
        VALUES(?, ?)
        SQL);
        $reqAddSignalement->execute([$signalement['idSignalement'], $isbn]);
    }

    // Ajout Ecrire //

    for($i = 0; $i < count($nomAuteurList); $i++)
    {
        $addEcrire = $mypdo->prepare(<<<SQL
        INSERT INTO Ecrire(ISBN, idAuteur)
        VALUES(?, ?)
        SQL);
        $addEcrire->execute([$isbn, $authorId[$i]]);
    }


    // Ajout Genre //

    for($i = 0; $i < count($genreList); $i++)
    {
        $req = $mypdo->prepare(<<<SQL
        SELECT idGenre FROM Genre
        WHERE UPPER(libGenre) = UPPER(?)
        SQL);
        $req->execute([$genreList[$i]]);
        $genreExist = $req->fetch();

        if (!$genreExist) {
            $addGenre = $mypdo->prepare(<<<SQL
            INSERT INTO Genre(libGenre)
            VALUES(?)
        SQL
            );
            $addGenre->execute([$genreList[$i]]);

            $req = $mypdo->prepare(<<<SQL
            SELECT idGenre FROM Genre
            WHERE UPPER(libGenre) = UPPER(?)
            SQL);
            $req->execute([$genreList[$i]]);
            $genreId[] = $req->fetch()['idGenre'];
        }
        else{
            $genreId[] = $genreExist['idGenre'];
        }

        $addGenre = $mypdo->prepare(<<<SQL
        INSERT INTO AvoirGenre(ISBN, idGenre)
        VALUES(?, ?)
        SQL);
        $addGenre->execute([$isbn, $genreId[$i]]);
    }
}
header('Location: ../editBook.php?isbn='.$isbn);