<?php
declare(strict_types=1);

class Livre
{
    private String $ISBN;
    private String $titre;
    private String $datePublication;
    private int $nbPages;
    private String $langue;
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
     * @param string $ISBN
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function createFromId(string $ISBN):self //throw InvalidArgumentException
    {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Livre
                WHERE ISBN = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $req->execute([$ISBN]);
        $livre=$req->fetch();
        if(!$livre)
            throw new InvalidArgumentException("ISBN non existant dans la base de donnée.");
        return $livre;
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
    public function getLangue(): string
    {
        return $this->langue;
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
    public function getGenres():array
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
     */
    public function getAppreciations():array
    {
        $stat = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Appreciation a 
                    INNER JOIN Livre l ON l.ISBN = a.ISBN
                WHERE a.ISBN = ?
                SQL);
        $stat->setFetchMode(PDO::FETCH_CLASS, Appreciation::class);
        $stat->execute([$this->ISBN]);
        return $stat->fetchAll();;
    }

    public function getNbAppreciations():int
    {
        return count($this->getAppreciations());
    }

    /**
     * Retourne la note moyenne d'un livre en fonction de toutes ses appréciations.
     * @return float
     */
    public function getNoteMoyenne():float
    {
        $stat = MyPDO::getInstance()->prepare(<<<SQL
                SELECT AVG(note)
                FROM Appreciation a 
                    INNER JOIN Livre l ON l.ISBN = a.ISBN
                WHERE a.ISBN = ?
                SQL);
        $stat->execute([$this->ISBN]);
        $valeur=$stat->fetch()['AVG(note)'];
        if($valeur==null)
            $valeur=-1;
        return (float)($valeur);
    }

    /**
     * Retourne les auteurs du livre sous forme d'instance de Auteur.
     * @return array
     */
    public function getAuteurs():array
    {
        $stat = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Auteur a
                    INNER JOIN Ecrire e ON a.idAuteur = e.idAuteur
                WHERE e.ISBN = ?
                SQL);
        $stat->setFetchMode(PDO::FETCH_CLASS, Auteur::class);
        $stat->execute([$this->ISBN]);
        return $stat->fetchAll();
    }

    public static function getAll():array
    {
        $stat = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Livre
                ORDER BY titre
                SQL);
        $stat->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $stat->execute();
        return $stat->fetchAll();
    }


    public static function getResearch(String $research, array $authors, array $years, array $editeurs, array $genres, array $languages):array {

        $sql = <<<SQL
                SELECT l.ISBN, l.titre, l.datePublication, l.nbPages, l.langue, l.description, l.prix, l.qte, l.idEditeur, l.idCouv, l.idFormat, l.idSupport
                FROM Livre l
                    LEFT JOIN Ecrire e ON l.ISBN = e.ISBN
                    LEFT JOIN Auteur a ON e.idAuteur = a.idAuteur
                    LEFT JOIN Editeur ed ON l.idEditeur = ed.idEditeur
                    LEFT JOIN AvoirGenre ag ON ag.ISBN = l.ISBN
                    LEFT JOIN Genre g ON ag.idGenre = g.idGenre
                WHERE (UPPER(l.titre) LIKE UPPER('%{$research}%')
                    OR UPPER(a.nom) LIKE UPPER('%{$research}%')
                    OR UPPER(a.prnm) LIKE UPPER('%{$research}%')
                    OR UPPER(l.ISBN) = UPPER('%{$research}%'))
        SQL;

        // Auteurs

        if(!empty($authors)){
            $authorSQL = " AND (";
            for($i = 0; $i < count($authors); $i++){
                $authorSQL .= "UPPER(a.nom) LIKE UPPER('%{$authors[$i]}%') OR UPPER(a.prnm) LIKE UPPER('%{$authors[$i]}%')";
                if($i < count($authors)-1){
                    $authorSQL .= " OR ";
                }
            }
            $authorSQL .= ")";
            $sql .= $authorSQL;
        }

        // Années

        if(!empty($years)){
            $yearSQL = " AND (";
            for($i = 0; $i < count($years); $i++){
                $yearSQL .= "l.datePublication = {$years[$i]}";
                if($i < count($years)-1){
                    $yearSQL .= " OR ";
                }
            }
            $yearSQL .= ")";
            $sql .= $yearSQL;
        }

        // Editeurs

        if(!empty($editeurs)){
            $editeurSQL = " AND (";
            for($i = 0; $i < count($editeurs); $i++){
                $editeurSQL .= "UPPER(ed.libEditeur) LIKE UPPER('%{$editeurs[$i]}%')";
                if($i < count($editeurs)-1){
                    $editeurSQL .= " OR ";
                }
            }
            $editeurSQL .= ")";
            $sql .= $editeurSQL;
        }

        // Genres

        if(!empty($genres)){
            $genreSQL = " AND (";
            for($i = 0; $i < count($genres); $i++){
                $genreSQL .= "UPPER(g.libGenre) LIKE UPPER('%{$genres[$i]}%')";
                if($i < count($genres)-1){
                    $genreSQL .= " OR ";
                }
            }
            $genreSQL .= ")";
            $sql .= $genreSQL;
        }

        // Langages

        if(!empty($languages)) {
            $languageSQL = " AND (";
            for ($i = 0; $i < count($languages); $i++) {
                $languageSQL .= "UPPER(l.langue) = UPPER('{$languages[$i]}')";
                if ($i < count($languages) - 1) {
                    $languageSQL .= " OR ";
                }
            }
            $languageSQL .= ")";
            $sql .= $languageSQL;
        }
        $sql .= ' ORDER BY l.titre';


        $stat = MyPDO::getInstance()->prepare($sql);
        $stat->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stat->execute();
        return $stat->fetchAll();

    }
}