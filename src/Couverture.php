<?php
declare(strict_types=1);

class Couverture
{

    private int $idCouv;
    private String $png;

    public function __construct() {}

    public static function createFromId(int $idCouv) {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Couverture
                WHERE idCouv = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Couverture::class);
        $req->execute([$idCouv]);
        return $req->fetch();
    }

    /**
     * @return int
     */
    public function getIdCouv(): int
    {
        return $this->idCouv;
    }

    /**
     * @return String
     */
    public function getPng(): string
    {
        return $this->png;
    }

}