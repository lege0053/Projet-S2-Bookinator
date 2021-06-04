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

    private function __construct() {}

    /**
     * Retourne une instance de la classe Livre à portir d'un id.
     * @param int $ISBN
     * @return mixed
     * @throws Exception
     */
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
     * Accesseur de la date de publication.
     * @return String
     */
    public function getDatePublication(): string
    {
        return $this->datePublication;
    }

    /**
     * Accesseur de la description.
     * @return String
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Accesseur de l'idCouv.
     * @return int
     */
    public function getIdCouv(): int
    {
        return $this->idCouv;
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
     * Accesseur de l'idFormat.
     * @return int
     */
    public function getIdFormat(): int
    {
        return $this->idFormat;
    }

    /**
     * Accesseur de l'idSupport.
     * @return int
     */
    public function getIdSupport(): int
    {
        return $this->idSupport;
    }

    /**
     * Accesseur de l'ISBN.
     * @return String
     */
    public function getISBN(): string
    {
        return $this->ISBN;
    }

    /**
     * Accesseur de la langue.
     * @return String
     */
    public function getLangues(): string
    {
        return $this->langues;
    }

    /**
     * Accesseur du nombre de pages.
     * @return int
     */
    public function getNbPages(): int
    {
        return $this->nbPages;
    }

    /**
     * Accesseur du prix.
     * @return float
     */
    public function getPrix(): float
    {
        return $this->prix;
    }

    /**
     * Accesseur de la quantité.
     * @return int
     */
    public function getQte(): int
    {
        return $this->qte;
    }

    /**
     * Accesseur du titre.
     * @return String
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * Retourne sous forme d'instance de genre les genres du livre.
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

    /**
     * Retourne sous forme d'appréciation les appréciations du livre.
     * @return array
     * @throws Exception
     */
    public function getAppreciation()
    {
        $stat = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Appreciation a 
                    INNER JOIN Livre l ON l.ISBN = a.ISBN
                WHERE a.ISBN = ?
                SQL);
        $stat->setFetchMode(PDO::FETCH_CLASS, Appreciation::class);
        $stat->execute([$this->ISBN]);
        return $stat->fetchAll();
    }

    /**
     * Retourne la note moyenne d'un livre en fonction de toutes les appréciations.
     * @return mixed
     * @throws Exception
     */
    public function getNoteMoyenne()
    {
        $stat = MyPDO::getInstance()->prepare(<<<SQL
                SELECT AVG(note)
                FROM Appreciation a 
                    INNER JOIN Livre l ON l.ISBN = a.ISBN
                WHERE a.ISBN = ?
                SQL);
        $stat->execute([$this->ISBN]);
        return $stat->fetch();
    }
}