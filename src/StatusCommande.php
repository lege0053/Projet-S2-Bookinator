<?php
declare(strict_types=1);

class StatusCommande
{
    private int $idStatus;
    private String $libStatus;

    private function __construct() {}

    /**
     * Reoturne une instance de StatusCommande à partir d'un id.
     * @param int $idStatus
     * @return mixed
     * @throws Exception
     */
    public static function createFromId(int $idStatus) {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM StatusCommande
                WHERE idStatus = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, StatusCommande::class);
        $req->execute([$idStatus]);
        return $req->fetch();
    }

    /**
     * Accesseur de idStatus.
     * @return int
     */
    public function getIdStatus(): int
    {
        return $this->idStatus;
    }

    /**
     * Accesseur de libStatus.
     * @return String
     */
    public function getLibStatus(): string
    {
        return $this->libStatus;
    }

}