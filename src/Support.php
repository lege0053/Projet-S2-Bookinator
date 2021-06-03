<?php


class Support
{
    private int $idSupport;
    private string $libSupport;

    public function __construct(){}

    /**
     * @return int
     */
    public function getIdSupport(): int
    {
        return $this->idSupport;
    }

    /**
     * @return string
     */
    public function getLibSupport(): string
    {
        return $this->libSupport;
    }



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