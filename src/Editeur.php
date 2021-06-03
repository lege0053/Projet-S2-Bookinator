<?php
declare(strict_types=1);

class Editeur
{
    private int $idEditeur;
    private String $libEditeur;

    public function __construct() {}

    public static function createFromId(int $idEditeur) {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Editeur
                WHERE idEditeur = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Editeur::class);
        $req->execute([$idEditeur]);
        return $req->fetch();
    }

    /**
     * @return int
     */
    public function getIdEditeur(): int
    {
        return $this->idEditeur;
    }

    /**
     * @return String
     */
    public function getLibEditeur(): string
    {
        return $this->libEditeur;
    }

    public function getLivres() {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Editeur e 
                    INNER JOIN Livre l ON e.idEditeur = l.idEditeur
                WHERE e.idEditeur = ?
                ORDER BY l.titre
                SQL);
        $req->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $req->execute([$this->idEditeur]);
        return $req->fetchAll();
    }
}