<?php
declare(strict_types=1);

class Support
{
    private int $idSupport;
    private string $libSupport;

    private function __construct(){}

    /**
     * Accesseur de l'idSupport.
     * @return int
     */
    public function getIdSupport(): int
    {
        return $this->idSupport;
    }

    /**
     * Accesseur de libSupport.
     * @return string
     */
    public function getLibSupport(): string
    {
        return $this->libSupport;
    }

    /**
     * Retourne une instance de support à partir d'un id.
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public static function createFromId(int $id)
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT * 
            FROM Support
            WHERE idSupport = :id
            SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Support::class );

        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    /**
     * Retourne sous forme d'instance de livre tout les livres du format.
     * @return array
     * @throws Exception
     */
    public function getLivres()
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT * 
        FROM Support s
            INNER JOIN Livre l ON s.idSupport=l.idSupport
        WHERE idSupport = :id
        SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Livre::class );

        $stmt->execute([":id" => $this->idSupport]);
        return $stmt->fetchAll();
    }
}