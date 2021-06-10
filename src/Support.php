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
    public static function createFromId(int $id):self
    {

        $stmt = MyPDO::getInstance()->prepare(<<<SQL
            SELECT * 
            FROM Support
            WHERE idSupport = :id
            SQL);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Support::class );

        $stmt->execute([":id" => $id]);
        $retour=$stmt->fetch();
        if(!$retour)
            throw new InvalidArgumentException("Le support n'est pas dans la base de donnée.");
        return $retour;
    }

    /**
     * Retourne la liste de tous les support.
     * @return array
     */
    public static function getAll() : array
    {
        $req = MyPDO::getInstance()->prepare(<<<SQL
            SELECT * 
            FROM Support
            ORDER BY libSupport
        SQL);
        $req->setFetchMode(PDO::FETCH_CLASS, self::class );
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Retourne sous forme d'instance de livre tout les livres du format.
     * @return array
     * @throws Exception
     */
    public function getLivres():array
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