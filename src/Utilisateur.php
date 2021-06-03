<?php
declare(strict_types=1);

class Utilisateur
{
    private int $idUtilisateur;
    private String $nom;
    private String $prnm;
    private String $dateNais;
    private String $tel;
    private String $mail;
    private String $ville;
    private String $CP;
    private String $rue;
    private String $pseudo;
    private String $mdp;
    private String $photoProfil;
    private int $isAdmin;

    public function __construct()
    {
    }

    /**
     * @param int $idUtilisateur
     * @return mixed
     */
    public static function createFromId(int $idUtilisateur)
    {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Utilisateur
                WHERE idUtilisateur = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Utilisateur::class);
        $req->execute([$idUtilisateur]);
        return $req->fetch();
    }

    /**
     * @return String
     */
    public function getCP(): string
    {
        return $this->CP;
    }

    /**
     * @return String
     */
    public function getDateNais(): String
    {
        return $this->dateNais;
    }

    /**
     * @return int
     */
    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    /**
     * @return int
     */
    public function getIsAdmin(): int
    {
        return $this->isAdmin;
    }

    /**
     * @return String
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @return String
     */
    public function getMdp(): string
    {
        return $this->mdp;
    }

    /**
     * @return String
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return String
     */
    public function getPhotoProfil(): string
    {
        return $this->photoProfil;
    }

    /**
     * @return String
     */
    public function getPrnm(): string
    {
        return $this->prnm;
    }

    /**
     * @return String
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * @return String
     */
    public function getRue(): string
    {
        return $this->rue;
    }

    /**
     * @return String
     */
    public function getTel(): string
    {
        return $this->tel;
    }

    /**
     * @return String
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    public function getCommandes() {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Commande cmd 
                    INNER JOIN Utilisateur u ON u.idUtilisateur = cmd.idUtilisateur
                WHERE u.idUtilisateur = ?
                ORDER BY cmd.idCmd
                SQL);
        $req->setFetchMode(PDO::FETCH_CLASS, Commande::class);
        $req->execute([$this->idUtilisateur]);
        return $req->fetchAll();
    }

    public function getFavoris() {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Favoris fav 
                    INNER JOIN Livres l ON fav.ISBN = l.ISBN
                WHERE fav.idUtilisateur = ?
                ORDER BY l.titre
                SQL);
        $req->setFetchMode(PDO::FETCH_CLASS, Livre::class);
        $req->execute([$this->idUtilisateur]);
        return $req->fetchAll();
    }
}