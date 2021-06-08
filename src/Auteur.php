<?php
declare(strict_types=1);

class Auteur
{
    private int $idAuteur;
    private string $nom;
    private string $prnm;
    private string $dateNais;

    private function __construct() {}

    /**
     * Accesseur de l'idAuteur.
     * @return int
     */
    public function getIdAuteur(): int
    {
        return $this->idAuteur;
    }

    /**
     * Accesseur du nom de l'auteur.
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Accesseur du prénom de l'auteur.
     * @return string
     */
    public function getPrnm(): string
    {
        return $this->prnm;
    }

    /**
     * Accesseur de la date de naissance.
     * @return string
     */
    public function getDateNais(): string
    {
        return $this->dateNais;
    }

    /**
     * Retourne une instance de la classe Auteur à partir d'un id.
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public static function createFromId(int $id):self
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Auteur
        WHERE idAuteur = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Auteur::class );

        $stmt->execute([":id" => $id]);

        $retour=$stmt->fetch();
        if(!$retour)
            throw new InvalidArgumentException("L'auteur n'est pas dans la base de donnée.");
        return $retour;
    }

    /**
     * Retourne un ensemble d'instance de tout les livres de l'auteur.
     * @return array
     * @throws Exception
     */
    public function getLivres():array {
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