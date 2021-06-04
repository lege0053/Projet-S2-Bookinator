<?php
declare(strict_types=1);

class Couverture
{
    private int $idCouv;
    private String $png;

    private function __construct() {}

    /**
     * Retourune une instance de la classe Couverture à partir d'un id.
     * @param int $idCouv
     * @return mixed
     * @throws Exception
     */
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
     * Accesseur de l'idCouv.
     * @return int
     */
    public function getIdCouv(): int
    {
        return $this->idCouv;
    }

    /**
     * Accesseur du png.
     * @return String
     */
    public function getPng(): string
    {
        return $this->png;
    }
}