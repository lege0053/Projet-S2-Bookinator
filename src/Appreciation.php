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

    private function __construct() {}

    /**
     * Retourne une instance de la classe Appreciation à partir d'un id.
     * @param int $idAppreciation
     * @return mixed
     * @throws Exception
     */
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
     * Accesseur de ISBN.
     * @return String
     */
    public function getISBN(): string
    {
        return $this->ISBN;
    }

    /**
     * Accesseur de l'idUtilisateur
     * @return int
     */
    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    /**
     * Accesseur de commentaire.
     * @return String
     */
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    /**
     * Accesseur de date.
     * @return String
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Accesseur de l'idAppreciation.
     * @return int
     */
    public function getIdAppreciation(): int
    {
        return $this->idAppreciation;
    }

    /**
     * Accesseur de la note.
     * @return int
     */
    public function getNote(): int
    {
        return $this->note;
    }
}