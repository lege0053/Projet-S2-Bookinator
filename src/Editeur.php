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

}