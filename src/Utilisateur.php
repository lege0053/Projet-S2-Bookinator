<?php
declare(strict_types=1);

class Utilisateur
{
    private int $idUtilisateur;
    private String $nom;
    private String $prnm;
    private String $dateNais;
    private string $tel;
    private String $mail;
    private string $ville;
    private string $CP;
    private string $rue;
    private string $pseudo;
    private String $mdp;
    private string $photoProfil;
    private int $isAdmin;

    private function __construct(){}

    /**
     * Retourne une instance de la classe Utilisateur à partir d'un id.
     * @param int $idUtilisateur
     * @return mixed
     */
    public static function createFromId(int $idUtilisateur):self
    {
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Utilisateur
                WHERE idUtilisateur = ?
        SQL);

        $req->setFetchMode(PDO::FETCH_CLASS, Utilisateur::class);
        $req->execute([$idUtilisateur]);
        $retour=$req->fetch();
        if(!$retour)
            throw new InvalidArgumentException("L'utilisateur n'est pas dans la base de donnée.");
        return $retour;
    }

    /**
     * Accesseur du CP.
     * @return String
     */
    public function getCP(): string
    {
        return $this->CP == null ? "" : $this->CP;
    }

    /**
     * Accesseur de la Date de naissance.
     * @return String
     */
    public function getDateNais(): String
    {
        return $this->dateNais;
    }

    /**
     * Accesseur de l'idUtilisateur.
     * @return int
     */
    public function getIdUtilisateur(): int
    {
        return $this->idUtilisateur;
    }

    /**
     * Accesseur de isAdmin.
     * @return int
     */
    public function getIsAdmin(): int
    {
        return $this->isAdmin;
    }

    /**
     * Accesseur du mail.
     * @return String
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * Accesseur du mot de passe.
     * @return String
     */
    public function getMdp(): string
    {
        return $this->mdp;
    }

    /**
     * Accesseur du nom.
     * @return String
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Accesseur de la photo de profil.
     * @return String
     */
    public function getPhotoProfil(): string
    {
        return $this->photoProfil == null ? "" : $this->photoProfil;
    }

    /**
     * Accesseur du prénom.
     * @return String
     */
    public function getPrenom(): string
    {
        return $this->prnm;
    }

    /**
     * Accesseur du pseudo.
     * @return String
     */
    public function getPseudo(): string
    {
        return $this->pseudo == null ? "" : $this->pseudo;
    }

    /**
     * Accesseur de la rue.
     * @return String
     */
    public function getRue(): string
    {
        return $this->rue == null ? "" : $this->rue;
    }

    /**
     * Accesseur du téléphone.
     * @return String
     */
    public function getTel(): string
    {
        return $this->tel == null ? "" : $this->tel;
    }

    /**
     * Accesseur de la ville/
     * @return String
     */
    public function getVille(): string
    {
        return $this->ville == null ? "" : $this->ville;
    }

    /**
     * Retourne sous formes d'instance de Commande tout les commandes de l'utilisateur.
     * @return array
     */
    public function getCommandes():array {
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

    /**
     * Retourne sous forme d'instance de Livre tout les livre en favoris de l'utilisateur.
     * @return array
     */
    public function getFavoris():array {
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

    public function getPanier():Commande{
        $req = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Commande cmd 
                    INNER JOIN Utilisateur u ON u.idUtilisateur = cmd.idUtilisateur
                WHERE u.idUtilisateur = ?
                AND idStatus=3
                SQL);
        $req->setFetchMode(PDO::FETCH_CLASS, Commande::class);
        $req->execute([$this->idUtilisateur]);
        $retourReq=$req->fetchAll();
        $retourFinal=$retourReq[0];
        if(count($retourReq)>1)
        {
            $nb=count($retourReq);
            throw new UnexpectedValueException("La fonction retourne + d'une commande en cours : $nb ");
        }
        if(!$retourReq)
        {
            $req = MyPDO::getInstance()->prepare(<<<SQL
                INSERT INTO Commande(idCmd, idUtilisateur, idStatus, prixCmd, dateCmd, villeLivraison, CPLivraison, rueLivraison)
                VALUES(null, $this->idUtilisateur, 3, 0, SYSDATE(), " ", " ", " ")
                SQL);
            $req->execute();

            $req2 = MyPDO::getInstance()->prepare(<<<SQL
                SELECT *
                FROM Commande cmd 
                    INNER JOIN Utilisateur u ON u.idUtilisateur = cmd.idUtilisateur
                WHERE u.idUtilisateur = ?
                AND idStatus=3
                SQL);
            $req2->setFetchMode(PDO::FETCH_CLASS, Commande::class);
            $req2->execute([$this->idUtilisateur]);
            $retourFinal=$req2->fetch();
        }
        return $retourFinal;
    }
}