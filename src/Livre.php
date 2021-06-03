<?php
declare(strict_types=1);

class Livre
{
    private String $ISBN;
    private String $titre;
    private String $datePublication;
    private int $nbPages;
    private String $langues;
    private String $description;
    private float $prix;
    private int $qte;
    private int $idEditeur;
    private int $idCouv;
    private int $idFormat;
    private int $idSupport;

    public function __construct() {}

    public static function createFromId(int $ISBN) {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Livre
                WHERE ISBN = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $req->execute([$ISBN]);
        return $req->fetch();
    }

    /**
     * @return String
     */
    public function getDatePublication(): string
    {
        return $this->datePublication;
    }

    /**
     * @return String
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getIdCouv(): int
    {
        return $this->idCouv;
    }

    /**
     * @return int
     */
    public function getIdEditeur(): int
    {
        return $this->idEditeur;
    }

    /**
     * @return int
     */
    public function getIdFormat(): int
    {
        return $this->idFormat;
    }

    /**
     * @return int
     */
    public function getIdSupport(): int
    {
        return $this->idSupport;
    }

    /**
     * @return String
     */
    public function getISBN(): string
    {
        return $this->ISBN;
    }

    /**
     * @return String
     */
    public function getLangues(): string
    {
        return $this->langues;
    }

    /**
     * @return int
     */
    public function getNbPages(): int
    {
        return $this->nbPages;
    }

    /**
     * @return float
     */
    public function getPrix(): float
    {
        return $this->prix;
    }

    /**
     * @return int
     */
    public function getQte(): int
    {
        return $this->qte;
    }

    /**
     * @return String
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @return mixed
     */
    public function getGenres()
    {
        $stat = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM AvoirGenre a 
                    INNER JOIN Genre g ON a.idGenre = g.idGenre
                WHERE a.ISBN = ?
                ORDER BY g.libGenre
                SQL);
        $stat->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        $stat->execute([$this->ISBN]);
        return $stat->fetchAll();
    }

}