<?php
declare(strict_types=1);

class Signalement
{
    private int $idSignalement;
    private string $contenu;
    private string $dateSig;
    private int $idUtilisateur;

    private function __construct(){}

    /**
     * @return int
     */
    public function getIdSignalement(): int
    {
        return $this->idSignalement;
    }

    /**
     * @return string
     */
    public function getContenu(): string
    {
        return $this->contenu;
    }

    /**
     * @return string
     */
    public function getDateSig(): string
    {
        return $this->dateSig;
    }

    /**
     * @return int
     */
    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    /**
     * Retourne une instance de la classe signalement à partir d'un id.
     * @param int $idSignalement
     * @return static
     * @throws Exception
     */
    public static function createFromId(int $idSignalement):self
    {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Signalement
                WHERE idSignalement = ?
        SQL
        );

        $req->setFetchMode(PDO::FETCH_CLASS, Signalement::class);
        $req->execute([$idSignalement]);
        $retour = $req->fetch();
        if (!$retour)
            throw new InvalidArgumentException("Le signalement n'est pas dans la base de donnée.");
        return $retour;
    }
}