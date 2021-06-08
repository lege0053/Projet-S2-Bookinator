<?php
declare(strict_types=1);

class Editeur
{
    private int $idEditeur;
    private String $libEditeur;

    private function __construct() {}

    /**
     * Retourne une instance de la classe editeur à partir d'un id.
     * @param int $idEditeur
     * @return mixed
     * @throws Exception
     */
    public static function createFromId(int $idEditeur) :self{
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Editeur
                WHERE idEditeur = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Editeur::class);
        $req->execute([$idEditeur]);

        $retour=$req->fetch();
        if(!$retour)
            throw new InvalidArgumentException("L'éditeur' n'est pas dans la base de donnée.");
        return $retour;
    }

    /**
     * Accesseur de l'idEditeur.
     * @return int
     */
    public function getIdEditeur(): int
    {
        return $this->idEditeur;
    }

    /**
     * Accesseur du libEditeur.
     * @return String
     */
    public function getLibEditeur(): string
    {
        return $this->libEditeur;
    }

    /**
     * Retourne sous forme d'instance de la classe livre l'ensemble des livres édité par l'éditeur.
     * @return array
     * @throws Exception
     */
    public function getLivres() :array{
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