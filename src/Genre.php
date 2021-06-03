<?php


class Genre
{
    private int $idGenre;
    private string $libGenre;

    public function __construct(){}

    /**
     * @return int
     */
    public function getIdGenre(): int
    {
        return $this->idGenre;
    }

    /**
     * @return string
     */
    public function getLibGenre(): string
    {
        return $this->libGenre;
    }

    public static function createFromId(int $id)
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Genre
        WHERE idGenre = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class );

        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public function getLivres()
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