<?php
declare(strict_types=1);

class Auteur
{
    private int $idAuteur;
    private string $nom;
    private string $prnm;
    private string $dateNais;

    public function __construct() {}

    /**
     * @return int
     */
    public function getIdAuteur(): int
    {
        return $this->idAuteur;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getPrnm(): string
    {
        return $this->prnm;
    }

    /**
     * @return string
     */
    public function getDateNais(): string
    {
        return $this->dateNais;
    }

    public static function createFromId(int $id)
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Auteur
        WHERE idAuteur = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Auteur::class );

        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public function getLivres() {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Ecrire e 
                    INNER JOIN Livre l ON e.ISBN = l.ISBN
                WHERE e.idAuteur = ?
                ORDER BY l.titre
                SQL);
        $req->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $req->execute([$this->idAuteur]);
        return $req->fetchAll();
    }
}