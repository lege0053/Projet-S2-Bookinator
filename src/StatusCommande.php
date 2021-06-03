<?php
declare(strict_types=1);

class StatusCommande
{

    private int $idStatus;
    private String $libStatus;

    public function __construct() {}

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
     * @return int
     */
    public function getIdStatus(): int
    {
        return $this->idStatus;
    }

    /**
     * @return String
     */
    public function getLibStatus(): string
    {
        return $this->libStatus;
    }

}