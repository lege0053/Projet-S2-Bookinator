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
                CONSTRAINT PK_UTILISATEUR PRIMARY KEY (idUtilisateur),
                CONSTRAINT CK_ISADMIN CHECK (isAdmin BETWEEN 0 AND 1)
);


CREATE SEQUENCE SIGNALEMENT_IDSIGNALEMENT_SEQ;

CREATE TABLE Signalement (
                idSignalement NUMBER NOT NULL,
                contenu VARCHAR2(500) NOT NULL,
                dateSig DATE NOT NULL,
                idUtilisateur NUMBER NOT NULL,
                CONSTRAINT PK_SIGNALEMENT PRIMARY KEY (idSignalement)
);


CREATE SEQUENCE STATUSCOMMANDE_IDSTATUS_SEQ;

CREATE TABLE StatusCommande (
                idStatus NUMBER NOT NULL,
                libStatus VARCHAR2(30) NOT NULL,
                CONSTRAINT PK_STATUSCOMMANDE PRIMARY KEY (idStatus)
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
                CONSTRAINT PK_COMMANDE PRIMARY KEY (idCmd)
);


CREATE SEQUENCE AUTEUR_IDAUTEUR_SEQ;

CREATE TABLE Auteur (
                idAuteur NUMBER NOT NULL,
                nom VARCHAR2(30) NOT NULL,
                prnm VARCHAR2(30) NOT NULL,
                dateNais DATE NOT NULL,
                CONSTRAINT PK_AUTEUR PRIMARY KEY (idAuteur)
);


CREATE SEQUENCE SUPPORT_IDSUPPORT_SEQ;

CREATE TABLE Support (
                idSupport NUMBER NOT NULL,
                libSupport VARCHAR2(30) NOT NULL,
                CONSTRAINT PK_SUPPORT PRIMARY KEY (idSupport)
);


CREATE SEQUENCE FORMAT_IDFORMAT_SEQ;

CREATE TABLE Format (
                idFormat NUMBER NOT NULL,
                libFormat VARCHAR2(30) NOT NULL,
                largeur FLOAT NOT NULL,
                hauteur FLOAT NOT NULL,
                CONSTRAINT PK_FORMAT PRIMARY KEY (idFormat)
);


CREATE SEQUENCE GENRE_IDGENRE_SEQ;

CREATE TABLE Genre (
                idGenre NUMBER NOT NULL,
                libGenre VARCHAR2(30) NOT NULL,
                CONSTRAINT PK_GENRE PRIMARY KEY (idGenre)
);


CREATE SEQUENCE EDITEUR_IDEDITEUR_SEQ;

CREATE TABLE Editeur (
                idEditeur NUMBER NOT NULL,
                libEditeur VARCHAR2(30) NOT NULL,
                CONSTRAINT PK_EDITEUR PRIMARY KEY (idEditeur)
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
                CONSTRAINT PK_LIVRE PRIMARY KEY (ISBN)
);


CREATE TABLE Favoris (
                ISBN VARCHAR2(13) NOT NULL,
                idUtilisateur NUMBER NOT NULL,
                CONSTRAINT PK_FAVORIS PRIMARY KEY (ISBN, idUtilisateur)
);


CREATE TABLE Contenu (
                idCmd NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT PK_CONTENU PRIMARY KEY (idCmd, ISBN)
);


CREATE TABLE Ecrire (
                idAuteur NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT PK_ECRIRE PRIMARY KEY (idAuteur, ISBN)
);


CREATE TABLE AvoirGenre (
                idGenre NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT PK_AVOIRGENRE PRIMARY KEY (idGenre, ISBN)
);


CREATE SEQUENCE APPRECIATION_IDAPPRECIATION_SEQ;

CREATE TABLE Appreciation (
                idAppreciation NUMBER NOT NULL,
                commentaire VARCHAR2(500) NOT NULL,
                note NUMBER NOT NULL,
                dateApp DATE NOT NULL,
                idUtilisateur NUMBER NOT NULL,
                ISBN VARCHAR2(13) NOT NULL,
                CONSTRAINT PK_APPRECIATION PRIMARY KEY (idAppreciation)
);


ALTER TABLE Livre ADD CONSTRAINT FK_COUVERTURE_LIVRE
FOREIGN KEY (idCouv)
REFERENCES Couverture (idCouv);

ALTER TABLE Commande ADD CONSTRAINT FK_UTILISATEUR_COMMANDE
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur);

ALTER TABLE Appreciation ADD CONSTRAINT FK_UTILISATEUR_APPRECIATION
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur);

ALTER TABLE Favoris ADD CONSTRAINT FK_UTILISATEUR_FAVORIS
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur);

ALTER TABLE Signalement ADD CONSTRAINT FK_UTILISATEUR_SIGNALEMENT
FOREIGN KEY (idUtilisateur)
REFERENCES Utilisateur (idUtilisateur);

ALTER TABLE Commande ADD CONSTRAINT FK_STATUSCOMMANDE_COMMANDE
FOREIGN KEY (idStatus)
REFERENCES StatusCommande (idStatus);

ALTER TABLE Contenu ADD CONSTRAINT FK_COMMANDE_CONTENU
FOREIGN KEY (idCmd)
REFERENCES Commande (idCmd);

ALTER TABLE Ecrire ADD CONSTRAINT FK_AUTEUR_ECRIRE
FOREIGN KEY (idAuteur)
REFERENCES Auteur (idAuteur);

ALTER TABLE Livre ADD CONSTRAINT FK_SUPPORT_LIVRE
FOREIGN KEY (idSupport)
REFERENCES Support (idSupport);

ALTER TABLE Livre ADD CONSTRAINT FK_FORMAT_LIVRE
FOREIGN KEY (idFormat)
REFERENCES Format (idFormat);

ALTER TABLE AvoirGenre ADD CONSTRAINT FK_GENRE_AVOIRGENRE
FOREIGN KEY (idGenre)
REFERENCES Genre (idGenre);

ALTER TABLE Livre ADD CONSTRAINT FK_EDITEUR_LIVRE
FOREIGN KEY (idEditeur)
REFERENCES Editeur (idEditeur);

ALTER TABLE Appreciation ADD CONSTRAINT FK_LIVRE_APPRECIATION
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN);

ALTER TABLE AvoirGenre ADD CONSTRAINT FK_LIVRE_AVOIRGENRE
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN);

ALTER TABLE Ecrire ADD CONSTRAINT FK_LIVRE_ECRIRE
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN);

ALTER TABLE Contenu ADD CONSTRAINT FK_LIVRE_CONTENU
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN);

ALTER TABLE Favoris ADD CONSTRAINT FK_LIVRE_FAVORIS
FOREIGN KEY (ISBN)
REFERENCES Livre (ISBN);

CREATE TABLE  SignalementCommentaire(     
                 idSignalement NUMBER NOT NULL,
                 idAppreciation NUMBER NOT NULL,
                 CONSTRAINT PK_IDSIGNALEMENT PRIMARY KEY (idSignalement),
                 CONSTRAINT FK_SIGNALEMENTCOMMENTAIRE_HERITAGE__SIGNALEMENT FOREIGN KEY (idSignalement) REFERENCES SIGNALEMENT (idSignalement),
                 CONSTRAINT FK_IDAPPRECIATION FOREIGN KEY (idAppreciation) REFERENCES Appreciation(idAppreciation)
);

CREATE TABLE  SignalementLivre(     
                 idSignalement NUMBER NOT NULL,
                 idLivre NUMBER NOT NULL,
                 CONSTRAINT PK_IDSIGNALEMENT PRIMARY KEY (idSignalement),
                 CONSTRAINT FK_SIGNALEMENTLIVRE_HERITAGE__SIGNALEMENT FOREIGN KEY (idSignalement) REFERENCES SIGNALEMENT (idSignalement),
                 CONSTRAINT FK_IDLIVRE FOREIGN KEY (idLivre) REFERENCES Livre(idLivre)
);

CREATE TABLE  SignalementCommande(     
                 idSignalement NUMBER NOT NULL,
                 idCommande NUMBER NOT NULL,
                 CONSTRAINT PK_IDSIGNALEMENT PRIMARY KEY (idSignalement),
                 CONSTRAINT FK_SIGNALEMENTCOMMANDE_HERITAGE__SIGNALEMENT FOREIGN KEY (idSignalement) REFERENCES SIGNALEMENT (idSignalement),
                 CONSTRAINT FK_IDCOMMANDE FOREIGN KEY (idCommande) REFERENCES Commande(idCommande)
);