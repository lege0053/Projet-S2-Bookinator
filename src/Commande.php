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

    private function __construct() {}

    /**
     * Retourne une instance de la classe Commande à partir d'un id.
     * @param int $idCmd
     * @return mixed
     * @throws Exception
     */
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
     * Accesseur de l'idUtilisateur.
     * @return int
     */
    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    /**
     * Accesseur du CP de livraison.
     * @return String
     */
    public function getCPLivraison(): string
    {
        return $this->CPLivraison;
    }

    /**
     * Accesseur de la date de la commande.
     * @return String
     */
    public function getDateCmd(): string
    {
        return $this->dateCmd;
    }

    /**
     * Accesseur de l'id de la commande.
     * @return int
     */
    public function getIdCmd(): int
    {
        return $this->idCmd;
    }

    /**
     * Accesseur du prix de la commande.
     * @return float
     */
    public function getPrixCmd(): float
    {
        return $this->prixCmd;
    }

    /**
     * Accesseur de la rue de livraison.
     * @return String
     */
    public function getRueLivraison(): string
    {
        return $this->rueLivraison;
    }

    /**
     * Accesseur de la ville de livraison.
     * @return String
     */
    public function getVilleLivraison(): string
    {
        return $this->villeLivraison;
    }
}