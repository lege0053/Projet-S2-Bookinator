<?php


class Format
{
    private int $idFormat;
    private string $libFormat;
    private float $largeur;
    private float $hauteur;

    public function __construct(){}

    /**
     * @return int
     */
    public function getIdFormat(): int
    {
        return $this->idFormat;
    }

    /**
     * @return string
     */
    public function getLibFormat(): string
    {
        return $this->libFormat;
    }

    /**
     * @return float
     */
    public function getLargeur(): float
    {
        return $this->largeur;
    }

    /**
     * @return float
     */
    public function getHauteur(): float
    {
        return $this->hauteur;
    }

    public static function createFromId(int $id)
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Format
        WHERE idFormat = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Format::class );

        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }
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