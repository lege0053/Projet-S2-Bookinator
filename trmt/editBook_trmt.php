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

// Auteur : Si il n'existe pas, on l'ajoute ! Et on récupère son id //
$req = $mypdo->prepare(<<<SQL
    SELECT ISBN FROM Livre
    WHERE UPPER(ISBN) = UPPER(?)
SQL);
$req->execute([$isbn]);
$exist = $req->fetch();

if(!$exist) {
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
    $image = $_FILES['couverture']['tmp_name'];
    $data = fopen($image, 'rb');
    $size = $_FILES['couverture']['size'];
    $contents = fread($data, $size);
    fclose($data);

    $addCouverture = $mypdo->prepare(<<<SQL
        INSERT INTO Couverture(png)
        VALUES(?)
    SQL
    );
    $addCouverture->execute([$contents]);
    $couvertureId = $mypdo->lastInsertId();

    // Ajout du Livre //

    $addLivre = $mypdo->prepare(<<<SQL
        INSERT INTO Livre(ISBN, titre, datePublication, nbPages, langue, description, prix, qte , idEditeur, idCouv, idFormat, idSupport)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    SQL
    );
    $addLivre->execute([$isbn, $titre, $datePublication, $nbPages, $langue, $description, $prix, $qte, $editeurId['idEditeur'], $couvertureId, $idFormat, $idSupport]);

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
header('Location: ../addBook.php');