<?php
declare(strict_types=1);

class Format
{
    private int $idFormat;
    private string $libFormat;
    private float $largeur;
    private float $hauteur;

    private function __construct(){}

    /**
     * Accesseur de l'idFormat.
     * @return int
     */
    public function getIdFormat(): int
    {
        return $this->idFormat;
    }

    /**
     * Accesseur de libFormat.
     * @return string
     */
    public function getLibFormat(): string
    {
        return $this->libFormat;
    }

    /**
     * Accesseur de la largeur.
     * @return float
     */
    public function getLargeur(): float
    {
        return $this->largeur;
    }

    /**
     * Accesseur de la longueur.
     * @return float
     */
    public function getHauteur(): float
    {
        return $this->hauteur;
    }

    /**
     * Retourne une instance de la classe format à partir d'un id.
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public static function createFromId(int $id):self
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Format
        WHERE idFormat = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Format::class );

        $stmt->execute([":id" => $id]);

        $retour=$stmt->fetch();
        if(!$retour)
            throw new InvalidArgumentException("Le format n'est pas dans la base de donnée.");
        return $retour;
    }

    /**
     * Retourne la liste de tous les Format.
     * @return array
     */
    public static function getAll() : array
    {
        $req = MyPDO::getInstance()->prepare(<<<SQL
            SELECT * 
            FROM Format
            ORDER BY libFormat
        SQL);
        $req->setFetchMode(PDO::FETCH_CLASS, Format::class );
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Retourne sous formes d'instance de livre tout les livres de ce format.
     * @return array
     * @throws Exception
     */
    public function getLivres()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Format f
            INNER JOIN Livre l ON f.idFormat=l.idFormat
        WHERE idFormat = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Livre::class );

        $stmt->execute([":id" => $this->idFormat]);
        return $stmt->fetchAll();


    }
}