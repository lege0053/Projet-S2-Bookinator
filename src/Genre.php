<?php
declare(strict_types=1);

class Genre
{
    private int $idGenre;
    private string $libGenre;

    private function __construct(){}

    /**
     * Accesseur de l'idGenre.
     * @return int
     */
    public function getIdGenre(): int
    {
        return $this->idGenre;
    }

    /**
     * Accesseur de libGenre.
     * @return string
     */
    public function getLibGenre(): string
    {
        return $this->libGenre;
    }

    /**
     * Retourne une instance de genre à partir d'un id.
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public static function createFromId(int $id):self
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Genre
        WHERE idGenre = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class );

        $stmt->execute([":id" => $id]);

        $retour=$stmt->fetch();
        if(!$retour)
            throw new InvalidArgumentException("Le genre n'est pas dans la base de donnée.");
        return $retour;
    }

    /**
     * Retourne sous forme d'instance de livre les livres de ce genre.
     * @return array
     * @throws Exception
     */
    public function getLivres():array
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM AvoirGenre g
            INNER JOIN Livre l ON g.ISBN=l.ISBN
        WHERE idGenre = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Livre::class );

        $stmt->execute([":id" => $this->idGenre]);
        return $stmt->fetchAll();
    }
}