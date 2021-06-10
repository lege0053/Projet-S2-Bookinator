<?php
declare(strict_types=1);

class Appreciation
{
    private int $idAppreciation;
    private String $commentaire;
    private int $note;
    private String $dateApp;
    private int $idUtilisateur;
    private String $ISBN;

    private function __construct() {}

    /**
     * Retourne une instance de la classe Appreciation à partir d'un id.
     * @param int $idAppreciation
     * @return mixed
     * @throws Exception
     */
    public static function createFromId(int $idAppreciation):self {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Appreciation
                WHERE idAppreciation = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Appreciation::class);
        $req->execute([$idAppreciation]);
        $retour=$req->fetch();
        if(!$retour)
            throw new InvalidArgumentException("L'appréciation n'est pas dans la base de donnée.");
        return $retour;
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
        return $this->dateApp;
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

    /**
     * Permet de déterminer si une appréciation se trouve dans la base de donnée ou non.
     * @param $isbn
     * @param $idUtilisateur
     * @return bool
     */
    public static function exist($isbn, $idUtilisateur):bool
    {
        $retour=true;
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Appreciation
                WHERE ISBN=?
                AND idUtilisateur=?
        SQL);
        $req->execute([$isbn, $idUtilisateur]);
        if(!$req->fetch())
            $retour=false;
        return $retour;
    }

    public static function existId($id):bool
    {
        $retour=true;
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Appreciation
                WHERE idAppreciation=?
        SQL);
        $req->execute([$id]);
        if(!$req->fetch())
            $retour=false;
        return $retour;
    }
}