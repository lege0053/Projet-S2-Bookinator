<?php
declare(strict_types=1);

class Appreciation
{

    private int $idAppreciation;
    private String $commentaire;
    private int $note;
    private String $date;
    private int $idUtilisateur;
    private String $ISBN;

    public function __construct() {}

    public static function createFromId(int $idAppreciation) {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Appreciation
                WHERE idAppreciation = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Appreciation::class);
        $req->execute([$idAppreciation]);
        return $req->fetch();
    }

    /**
     * @return String
     */
    public function getISBN(): string
    {
        return $this->ISBN;
    }

    /**
     * @return int
     */
    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    /**
     * @return String
     */
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    /**
     * @return String
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getIdAppreciation(): int
    {
        return $this->idAppreciation;
    }

    /**
     * @return int
     */
    public function getNote(): int
    {
        return $this->note;
    }

}