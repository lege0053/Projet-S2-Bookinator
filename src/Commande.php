<?php
declare(strict_types=1);

class Commande
{

    private int $idCmd;
    private int $idUtilisateur;
    private int $idStatus;
    private float $prixCmd;
    private String $dateCmd;
    private String $villeLivraison;
    private String $CPLivraison;
    private String $rueLivraison;

    public function __construct() {}

    public static function createFromId(int $idCmd) {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Commande
                WHERE idCmd = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Commande::class);
        $req->execute([$idCmd]);
        return $req->fetch();
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
    public function getCPLivraison(): string
    {
        return $this->CPLivraison;
    }

    /**
     * @return String
     */
    public function getDateCmd(): string
    {
        return $this->dateCmd;
    }

    /**
     * @return int
     */
    public function getIdCmd(): int
    {
        return $this->idCmd;
    }

    /**
     * @return int
     */
    public function getIdStatus(): int
    {
        return $this->idStatus;
    }

    /**
     * @return float
     */
    public function getPrixCmd(): float
    {
        return $this->prixCmd;
    }

    /**
     * @return String
     */
    public function getRueLivraison(): string
    {
        return $this->rueLivraison;
    }

    /**
     * @return String
     */
    public function getVilleLivraison(): string
    {
        return $this->villeLivraison;
    }

}