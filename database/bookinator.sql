
CREATE TABLE Couverture (
                idCouv INT AUTO_INCREMENT NOT NULL,
                png LONGBLOB NOT NULL,
                PRIMARY KEY (idCouv)
);


CREATE TABLE Utilisateur (
                idUser INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(30) NOT NULL,
                prnm VARCHAR(30) NOT NULL,
                dateNais DATE NOT NULL,
                tel CHAR(10) NOT NULL,
                mail VARCHAR(50) NOT NULL,
                city VARCHAR(38) NOT NULL,
                CP CHAR(5) NOT NULL,
                rue VARCHAR(40) NOT NULL,
                pseudo VARCHAR(30),
                password VARCHAR(123) NOT NULL,
                profileImage LONGBLOB,
                isAdmin INT DEFAULT 0 NOT NULL,
                PRIMARY KEY (idUser)
);


CREATE TABLE Signalement (
                idSignalement INT AUTO_INCREMENT NOT NULL,
                contenu VARCHAR(500) NOT NULL,
                dateSig DATE NOT NULL,
                idUser INT NOT NULL,
                PRIMARY KEY (idSignalement)
);


CREATE TABLE StatusCommande (
                idStatus INT AUTO_INCREMENT NOT NULL,
                libStatus VARCHAR(30) NOT NULL,
                PRIMARY KEY (idStatus)
);


CREATE TABLE Commande (
                idCmd INT AUTO_INCREMENT NOT NULL,
                idUser INT NOT NULL,
                idStatus INT NOT NULL,
                prixCmd DOUBLE NOT NULL,
                dateCmd DATE NOT NULL,
                villeLivraison VARCHAR(38) NOT NULL,
                CPLivraison VARCHAR(30) NOT NULL,
                rueLivraison VARCHAR(30) NOT NULL,
                PRIMARY KEY (idCmd)
);


CREATE TABLE SignalementCommande (
                idSignalement INT NOT NULL,
                idCmd INT NOT NULL,
                PRIMARY KEY (idSignalement, idCmd)
);


CREATE TABLE Auteur (
                idAuteur INT AUTO_INCREMENT NOT NULL,
                nom VARCHAR(30) NOT NULL,
                prnm VARCHAR(30) NOT NULL,
                dateNais DATE NOT NULL,
                PRIMARY KEY (idAuteur)
);


CREATE TABLE Support (
                idSupport INT AUTO_INCREMENT NOT NULL,
                libSupport VARCHAR(30) NOT NULL,
                PRIMARY KEY (idSupport)
);


CREATE TABLE Format (
                idFormat INT AUTO_INCREMENT NOT NULL,
                libFormat VARCHAR(30) NOT NULL,
                largeur DOUBLE NOT NULL,
                hauteur DOUBLE NOT NULL,
                PRIMARY KEY (idFormat)
);


CREATE TABLE Genre (
                idGenre INT AUTO_INCREMENT NOT NULL,
                libGenre VARCHAR(30) NOT NULL,
                PRIMARY KEY (idGenre)
);


CREATE TABLE Editeur (
                idEditeur INT AUTO_INCREMENT NOT NULL,
                libEditeur VARCHAR(30) NOT NULL,
                PRIMARY KEY (idEditeur)
);


CREATE TABLE Livre (
                ISBN VARCHAR(13) NOT NULL,
                titre VARCHAR(30) NOT NULL,
                datePublication DATE NOT NULL,
                nbPages INT NOT NULL,
                langue VARCHAR(30) NOT NULL,
                description TEXT NOT NULL,
                prix DOUBLE NOT NULL,
                qte INT NOT NULL,
                idEditeur INT NOT NULL,
                idCouv INT NOT NULL,
                idFormat INT NOT NULL,
                idSupport INT NOT NULL,
                PRIMARY KEY (ISBN)
);


CREATE TABLE Favoris (
                ISBN VARCHAR(13) NOT NULL,
                idUser INT NOT NULL,
                PRIMARY KEY (ISBN, idUser)
);


CREATE TABLE Contenu (
                idCmd INT NOT NULL,
                ISBN VARCHAR(13) NOT NULL,
                PRIMARY KEY (idCmd, ISBN)
);


CREATE TABLE Ecrire (
                idAuteur INT NOT NULL,
                ISBN VARCHAR(13) NOT NULL,
                PRIMARY KEY (idAuteur, ISBN)
);


CREATE TABLE AvoirGenre (
                idGenre INT NOT NULL,
                ISBN VARCHAR(13) NOT NULL,
                PRIMARY KEY (idGenre, ISBN)
);


CREATE TABLE Appreciation (
                idAppreciation INT AUTO_INCREMENT NOT NULL,
                commentaire VARCHAR(500) NOT NULL,
                note INT NOT NULL,
                dateApp DATE NOT NULL,
                idUser INT NOT NULL,
                ISBN VARCHAR(13) NOT NULL,
                PRIMARY KEY (idAppreciation)
);


CREATE TABLE SignalementCommentaire (
                idAppreciation INT NOT NULL,
                idSignalement INT NOT NULL,
                PRIMARY KEY (idAppreciation, idSignalement)
);


ALTER TABLE Livre ADD CONSTRAINT couverture_livre_fk
FOREIGN KEY (idCouv)
REFERENCES Couverture (idCouv)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Commande ADD CONSTRAINT utilisateur_commande_fk
FOREIGN KEY (idUser)
REFERENCES Utilisateur (idUser)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Appreciation ADD CONSTRAINT utilisateur_appreciation_fk
FOREIGN KEY (idUser)
REFERENCES Utilisateur (idUser)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Favoris ADD CONSTRAINT utilisateur_favoris_fk
FOREIGN KEY (idUser)
REFERENCES Utilisateur (idUser)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Signalement ADD CONSTRAINT utilisateur_signalement_fk
FOREIGN KEY (idUser)
REFERENCES Utilisateur (idUser)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE SignalementCommentaire ADD CONSTRAINT signalement_signalementcommentaire_fk
FOREIGN KEY (idSignalement)
REFERENCES Signalement (idSignalement)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE SignalementCommande ADD CONSTRAINT signalement_signalementcommande_fk
FOREIGN KEY (idSignalement)
REFERENCES Signalement (idSignalement)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Commande ADD CONSTRAINT statuscommande_commande_fk
FOREIGN KEY (idStatus)
REFERENCES StatusCommande (idStatus)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Contenu ADD CONSTRAINT commande_contenu_fk
FOREIGN KEY (idCmd)
REFERENCES Commande (idCmd)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE SignalementCommande ADD CONSTRAINT commande_signalementcommande_fk
FOREIGN KEY (idCmd)
REFERENCES Commande (idCmd)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Ecrire ADD CONSTRAINT auteur_ecrire_fk
FOREIGN KEY (idAuteur)
REFERENCES Auteur (idAuteur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Livre ADD CONSTRAINT support_livre_fk
FOREIGN KEY (idSupport)
REFERENCES Support (idSupport)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Livre ADD CONSTRAINT format_livre_fk
FOREIGN KEY (idFormat)
REFERENCES Format (idFormat)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE AvoirGenre ADD CONSTRAINT genre_avoirgenre_fk
FOREIGN KEY (idGenre)
REFERENCES Genre (idGenre)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Livre ADD CONSTRAINT editeur_livre_fk
FOREIGN KEY (idEditeur)
REFERENCES Editeur (idEditeur)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Appreciation ADD CONSTRAINT livre_appreciation_fk
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE AvoirGenre ADD CONSTRAINT livre_avoirgenre_fk
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Ecrire ADD CONSTRAINT livre_ecrire_fk
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Contenu ADD CONSTRAINT livre_contenu_fk
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE Favoris ADD CONSTRAINT livre_favoris_fk
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
ON DELETE NO ACTION
ON UPDATE NO ACTION;

ALTER TABLE SignalementCommentaire ADD CONSTRAINT appreciation_signalementcommentaire_fk
FOREIGN KEY (idAppreciation)
REFERENCES Appreciation (idAppreciation)
ON DELETE NO ACTION
ON UPDATE NO ACTION;
