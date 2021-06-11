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

    public static function getTypeSig($idSignalement): string {
        $type='-';

        /** Récupération des signalements Appreciation */
        $signsApp=MyPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM SignalementAppreciation
        SQL);
        $signsApp->execute();
        $signsApp=$signsApp->fetchAll();

        /** Récupération des signalements Commande */
        $signsCmd=MyPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM SignalementCommande
        SQL);
        $signsCmd->execute();
        $signsCmd=$signsCmd->fetchAll();

        /** Récupération des signalements Livre */
        $signsLvr=MyPDO::getInstance()->prepare(<<<SQL
            SELECT *
            FROM SignalementLivre
        SQL);
        $signsLvr->execute();
        $signsLvr=$signsLvr->fetchAll();

        /** Récupération du type d'appréciation */
        foreach($signsApp as $singApp)
        {
            if($singApp['idSignalement'] == $idSignalement){
                $type = 'Appreciation';
            }
        }
        foreach($signsCmd as $singCmd)
        {
            if($singCmd['idSignalement'] == $idSignalement){
                $type='Commande';
            }
        }
        foreach($signsLvr as $singLvr)
        {
            if($singLvr['idSignalement'] == $idSignalement){
                $type='Livre';
            }
        }

        return $type;
    }
}