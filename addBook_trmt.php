<?php
declare(strict_types=1);

require 'autoload.php';

$isbn = $_POST['isbn'];
$titre = $_POST['titre'];
$prix = $_POST['prix'];
$nbPages = $_POST['nbPages'];
$editeur = $_POST['editeur'];
$nomAuteur = $_POST['nomAuteur'];
$prenomAuteur = $_POST['prenomAuteur'];
$datePublication = $_POST['datePublication'];
$genre = $_POST['genre'];
$langue = $_POST['langue'];
$description = $_POST['description'];
$idFormat = $_POST['format'];
$idSupport = $_POST['support'];

$mypdo = MyPDO::getInstance();

$authorId = 1;
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
    $req = $mypdo->prepare(<<<SQL
        SELECT idAuteur FROM Auteur
        WHERE UPPER(nom) = UPPER(?)
        AND UPPER(prnm) = UPPER(?)
    SQL
    );
    $req->execute([$nomAuteur, $prenomAuteur]);
    $authorId = $req->fetch();
    if (!$authorId) {
        $addAuthor = $mypdo->prepare(<<<SQL
            INSERT INTO Auteur(nom, prnm, dateNais)
            VALUES(?,?, '1980-01-01')
        SQL
        );
        $addAuthor->execute([$nomAuteur, $prenomAuteur]);

        $req = $mypdo->prepare(<<<SQL
        SELECT idAuteur FROM Auteur
        WHERE UPPER(nom) = UPPER(?)
        AND UPPER(prnm) = UPPER(?)
        SQL
        );
        $req->execute([$nomAuteur, $prenomAuteur]);
        $authorId = $req->fetch();
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

    var_dump($couvertureId);

    // Ajout du Livre //

    $addLivre = $mypdo->prepare(<<<SQL
        INSERT INTO Livre(ISBN, titre, datePublication, nbPages, langue, description, prix, qte , idEditeur, idCouv, idFormat, idSupport)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    SQL
    );
    $addLivre->execute([$isbn, $titre, $datePublication, $nbPages, $langue, $description, $prix, 50, $editeurId['idEditeur'], $couvertureId, $idFormat, $idSupport]);

    // Ajout Ecrire //
    $addEcrire = $mypdo->prepare(<<<SQL
        INSERT INTO Ecrire(ISBN, idAuteur)
        VALUES(?, ?)
    SQL
    );
    $addEcrire->execute([$isbn, $authorId['idAuteur']]);


    // Ajout Genre //

    $req = $mypdo->prepare(<<<SQL
        SELECT idGenre FROM Genre
        WHERE UPPER(libGenre) = UPPER(?)
    SQL
    );
    $req->execute([$genre]);
    $genreId = $req->fetch();
    if (!$genreId) {
        $addGenre = $mypdo->prepare(<<<SQL
            INSERT INTO Genre(libGenre)
            VALUES(?)
        SQL
        );
        $addGenre->execute([$genre]);
        $genreId = $mypdo->lastInsertId();
    }else
        $genreId = $genreId['idGenre'];

    $addEcrire = $mypdo->prepare(<<<SQL
        INSERT INTO AvoirGenre(ISBN, idGenre)
        VALUES(?, ?)
    SQL
    );
    $addEcrire->execute([$isbn, $genreId]);
}
header('Location: addBook.php');