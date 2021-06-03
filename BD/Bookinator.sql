
CREATE SEQUENCE COUVERTURE_IDCOUV_SEQ;

CREATE TABLE Couverture (
                idCouv NUMBER NOT NULL,
                png BLOB NOT NULL,
                CONSTRAINT COUVERTURE_PK PRIMARY KEY (idCouv)
);


CREATE SEQUENCE UTILISATEUR_IDUTILISATEUR_SEQ;

CREATE TABLE Utilisateur (
                idUtilisateur NUMBER NOT NULL,
                nom VARCHAR2(30) NOT NULL,
                prnm VARCHAR2(30) NOT NULL,
                dateNais DATE NOT NULL,
                tel CHAR(10) NOT NULL,
                mail VARCHAR2(50) NOT NULL,
                ville VARCHAR2(38) NOT NULL,
                CP CHAR(5) NOT NULL,
                rue VARCHAR2(40) NOT NULL,
                pseudo VARCHAR2(30),
                mdp VARCHAR2(123) NOT NULL,
                photoProfil BLOB,
                isAdmin NUMBER DEFAULT 0 NOT NULL,
                CONSTRAINT UTILISATEUR_PK PRIMARY KEY (idUtilisateur)
);


CREATE SEQUENCE SIGNALEMENT_IDSIGNALEMENT_SEQ;

CREATE TABLE Signalement (
                idSignalement NUMBER NOT NULL,
                contenu VARCHAR2(500) NOT NULL,
                date_1 DATE NOT NULL,
                idUtilisateur NUMBER NOT NULL,
                CONSTRAINT SIGNALEMENT_PK PRIMARY KEY (idSignalement)
);


CREATE SEQUENCE STATUSCOMMANDE_IDSTATUS_SEQ;

CREATE TABLE StatusCommande (
                idStatus NUMBER NOT NULL,
                libStatus VARCHAR2(30) NOT NULL,
                CONSTRAINT STATUSCOMMANDE_PK PRIMARY KEY (idStatus)
);


CREATE SEQUENCE COMMANDE_IDCMD_SEQ;

CREATE TABLE Commande (
                idCmd NUMBER NOT NULL,
                idUtilisateur NUMBER NOT NULL,
                idStatus NUMBER NOT NULL,
                prixCmd FLOAT NOT NULL,
                dateCmd DATE NOT NULL,
                villeLivraison VARCHAR2(38) NOT NULL,
                CPLivraison VARCHAR2(30) NOT NULL,
                rueLivraison VARCHAR2(30) NOT NULL,
                CONSTRAINT COMMANDE_PK PRIMARY KEY (idCmd)
);


CREATE SEQUENCE AUTEUR_IDAUTEUR_SEQ;

CREATE TABLE Auteur (
                idAuteur NUMBER NOT NULL,
                nom VARCHAR2(30) NOT NULL,
                prnm VARCHAR2(30) NOT NULL,
                dateNais DATE NOT NULL,
                CONSTRAINT AUTEUR_PK PRIMARY KEY (idAuteur)
);


CREATE SEQUENCE SUPPORT_IDSUPPORT_SEQ;

CREATE TABLE Support (
                idSupport NUMBER NOT NULL,
                libSupport VARCHAR2(30) NOT NULL,
                CONSTRAINT SUPPORT_PK PRIMARY KEY (idSupport)
);


CREATE SEQUENCE FORMAT_IDFORMAT_SEQ;

CREATE TABLE Format (
                idFormat NUMBER NOT NULL,
                libFormat VARCHAR2(30) NOT NULL,
                largeur FLOAT NOT NULL,
                hauteur FLOAT NOT NULL,
                CONSTRAINT FORMAT_PK PRIMARY KEY (idFormat)
);


CREATE SEQUENCE GENRE_IDGENRE_SEQ;

CREATE TABLE Genre (
                idGenre NUMBER NOT NULL,
                libGenre VARCHAR2(30) NOT NULL,
                CONSTRAINT GENRE_PK PRIMARY KEY (idGenre)
);


CREATE SEQUENCE EDITEUR_IDEDITEUR_SEQ;

CREATE TABLE Editeur (
                idEditeur NUMBER NOT NULL,
                libEditeur VARCHAR2(30) NOT NULL,
                CONSTRAINT EDITEUR_PK PRIMARY KEY (idEditeur)
);


CREATE TABLE Livre (
                ISBN VARCHAR2(13) NOT NULL,
                titre VARCHAR2(30) NOT NULL,
                datePublication DATE NOT NULL,
                nbPages NUMBER NOT NULL,
                langue VARCHAR2(30) NOT NULL,
                description LONG NOT NULL,
                prix FLOAT NOT NULL,
                qte NUMBER NOT NULL,
                idEditeur NUMBER NOT NULL,
                idCouv NUMBER NOT NULL,
                idFormat NUMBER NOT NULL,
                idSupport NUMBER NOT NULL,
                CONSTRAINT LIVRE_PK PRIMARY KEY (ISBN)
);


CREATE TABLE Favoris (
                ISBN VARCHAR2(13) NOT NULL,
                idUtilisateur NUMBER NOT NULL,
                CONSTRAINT FAVORIS_PK PRIMARY KEY (ISBN, idUtilisateur)
);


CREATE TABLE Contenu (
                idCmd NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT CONTENU_PK PRIMARY KEY (idCmd, ISBN)
);


CREATE TABLE Ecrire (
                idAuteur NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT ECRIRE_PK PRIMARY KEY (idAuteur, ISBN)
);


CREATE TABLE AvoirGenre (
                idGenre NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT AVOIRGENRE_PK PRIMARY KEY (idGenre, ISBN)
);


CREATE SEQUENCE APPRECIATION_IDAPPRECIATION602;

CREATE TABLE Appreciation (
                idAppreciation NUMBER NOT NULL,
                commentaire VARCHAR2(500) NOT NULL,
                note NUMBER NOT NULL,
                date_1 DATE NOT NULL,
                idUtilisateur NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT APPRECIATION_PK PRIMARY KEY (idAppreciation)
);


ALTER TABLE Livre ADD CONSTRAINT COUVERTURE_LIVRE_FK
FOREIGN KEY (idCouv)
REFERENCES Couverture (idCouv)
NOT DEFERRABLE;

ALTER TABLE Commande ADD CONSTRAINT UTILISATEUR_COMMANDE_FK
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur)
NOT DEFERRABLE;

ALTER TABLE Appreciation ADD CONSTRAINT UTILISATEUR_APPRECIATION_FK
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur)
NOT DEFERRABLE;

ALTER TABLE Favoris ADD CONSTRAINT UTILISATEUR_FAVORIS_FK
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur)
NOT DEFERRABLE;

ALTER TABLE Signalement ADD CONSTRAINT UTILISATEUR_SIGNALEMENT_FK
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur)
NOT DEFERRABLE;

ALTER TABLE Commande ADD CONSTRAINT STATUSCOMMANDE_COMMANDE_FK
FOREIGN KEY (idStatus)
REFERENCES StatusCommande (idStatus)
NOT DEFERRABLE;

ALTER TABLE Contenu ADD CONSTRAINT COMMANDE_CONTENU_FK
FOREIGN KEY (idCmd)
REFERENCES Commande (idCmd)
NOT DEFERRABLE;

ALTER TABLE Ecrire ADD CONSTRAINT AUTEUR_ECRIRE_FK
FOREIGN KEY (idAuteur)
REFERENCES Auteur (idAuteur)
NOT DEFERRABLE;

ALTER TABLE Livre ADD CONSTRAINT SUPPORT_LIVRE_FK
FOREIGN KEY (idSupport)
REFERENCES Support (idSupport)
NOT DEFERRABLE;

ALTER TABLE Livre ADD CONSTRAINT FORMAT_LIVRE_FK
FOREIGN KEY (idFormat)
REFERENCES Format (idFormat)
NOT DEFERRABLE;

ALTER TABLE AvoirGenre ADD CONSTRAINT GENRE_AVOIRGENRE_FK
FOREIGN KEY (idGenre)
REFERENCES Genre (idGenre)
NOT DEFERRABLE;

ALTER TABLE Livre ADD CONSTRAINT EDITEUR_LIVRE_FK
FOREIGN KEY (idEditeur)
REFERENCES Editeur (idEditeur)
NOT DEFERRABLE;

ALTER TABLE Appreciation ADD CONSTRAINT LIVRE_APPRECIATION_FK
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
NOT DEFERRABLE;

ALTER TABLE AvoirGenre ADD CONSTRAINT LIVRE_AVOIRGENRE_FK
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
NOT DEFERRABLE;

ALTER TABLE Ecrire ADD CONSTRAINT LIVRE_ECRIRE_FK
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
NOT DEFERRABLE;

ALTER TABLE Contenu ADD CONSTRAINT LIVRE_CONTENU_FK
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
NOT DEFERRABLE;

ALTER TABLE Favoris ADD CONSTRAINT LIVRE_FAVORIS_FK
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN)
NOT DEFERRABLE;
