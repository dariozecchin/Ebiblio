DROP DATABASE IF EXISTS EBIBLIO;
CREATE DATABASE IF NOT EXISTS EBIBLIO;
USE EBIBLIO;

SET SQL_SAFE_UPDATES = 0;

#tabella BIBLIOTECA
CREATE TABLE BIBLIOTECA (
	Nome VARCHAR(100) PRIMARY KEY,
    NoteStoriche VARCHAR(2000),
    SitoWeb VARCHAR(200),
	Latitudine DOUBLE,
    Longitudine DOUBLE,
    Indirizzo VARCHAR(30),
    Email VARCHAR(40)
) ENGINE = InnoDB;

#DROP TABLE BIBLIOTECA;

#INSERT INTO FERMATA(Nome,Latitudine,Longitudine,Pensilina) VALUES ("Ugo Bassi",45.34,12.35,1);

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#1
INSERT INTO BIBLIOTECA(Nome, NoteStoriche, SitoWeb, Latitudine, Longitudine, Indirizzo, Email) VALUES (
"Biblioteca Giuridica Antonio Cicu", #nome
"Dal 1986 nuova denominazione della Scuola di Perfezionamento in Scienze Amministrative. Scuola di Perfezionamento in diritto sanitario",#note storiche
"http://www.spisa.unibo.it/servizi-e-strutture/biblioteca", #sito web
44.49561833186448,#latitudine
11.354983255689804, #longitudine
"Via Belmeloro", #indirizzo
"abis.bibliotecaspisa@unibo.it" #email
);

#2
INSERT INTO BIBLIOTECA(Nome, NoteStoriche, SitoWeb, Latitudine, Longitudine, Indirizzo, Email) VALUES (
"Biblioteca di discipline umanistiche", #nome
"Dal 1979 nuova denominazione della Biblioteca Centrale della Facoltà di Lettere e Filosofia e di Magistero.",#note storiche
"http://bdu.sba.unibo.it", #sito web
44.497603315496185, #lat
11.351872992058594, #long
"Via Zamboni 36", #indirizzo
"bdu.lettere@unibo.it" #email
);

#3
INSERT INTO BIBLIOTECA(Nome, NoteStoriche, SitoWeb, Latitudine, Longitudine, Indirizzo, Email) VALUES (
"Biblioteca del Dipartimento di Scienze economiche", #nome
"Dal 1.4.83 assorbe BO123 - Biblioteca dell'Istituto di Economia e Finanza. Dal 1.5.87 assorbe BO128 - Biblioteca dell'Istituto di Politica Economica. Dal 1.1.96 assorbe BO211 - Fondo di Geografia. Dal 1.11.2009 la Sezione di Geografia è confluita nella Biblioteca del Dipartimento di Discipline Storiche, che assume dalla stessa data la nuova denominazione di Discipline Storiche, Antropologiche e Geografiche (BO222)",#note storiche
"http://bigiavi.sba.unibo.it/", #sito web
44.49785133792379, #lat
11.350509546431713, #long
"Via delle Belle Arti", #indirizzo
"info.bigiavi@unibo.it" #email
);

#4
INSERT INTO BIBLIOTECA(Nome, NoteStoriche, SitoWeb, Latitudine, Longitudine, Indirizzo, Email) VALUES (
"Biblioteca Nicola Matteucci", #nome
"Il primissimo nucleo bibliografico dell'attuale biblioteca viene costituito con la nascita nel 1964 della Facoltà di Scienze Politiche. Questo primo corpus bibliografico viene ospitato dalla Biblioteca Giuridica A. Cicu, e nella metà degli anni '70 sarà trasferito a Palazzo Hercolani per dar vita alla biblioteca dell'allora Istituto Storico Politico. Nei primi anni '80, dopo la riforma sull'autonomia dell'Università, l'Istituto cambia denominazione in Dipartimento di Politica, Istituzioni e Storia, denominazione associata anche alla biblioteca. Nell'ottobre del 2012, in attuazione della cosiddetta Riforma Gelmini, il Dipartimento di Politica, Istituzioni e Storia e il Dipartimento di Scienza della politica danno vita ad un unico dipartimento che acquisisce la denominazione di Dipartimento di Scienze Politiche e Sociali. Contestualmente si avviano i primi servizi integrati tra le due biblioteche. Tale processo si conclude nel Luglio del 2017 con la fusione dei patrimoni delle due biblioteche e nel novembre 2018 viene ufficialmente inaugurata la nuova biblioteca dedicata a Nicola Matteucci. Il patrimonio della biblioteca rispecchia gli ambiti disciplinari che si sono avvicendati in questi anni. Nuclei bibliografici molto consistenti sono relativi all'ambito della scienza politica, della teoria politica, dello storico e del diritto costituzionale. A questi si sono aggiunti importanti raccolte di sociologia, organizzazione e sistema politico.",#note storiche
"https://dsps.unibo.it/it/biblioteca", #sito web
44.4914471513754, #lat
11.353958032938591, #long
"Strada Maggiore", #indirizzo
"sps.bibliotecamatteucci@unibo.it" #email
);

#5
INSERT INTO BIBLIOTECA(Nome, NoteStoriche, SitoWeb, Latitudine, Longitudine, Indirizzo, Email) VALUES (
"Biblioteca Giuseppe Testoni", #nome
"Dal 1983 nuova denominazione dei BO129 - Istituto di Ragioneria e BO132 - Istituto di Tecnica Economica. Dal 2002 assorbe BO127 Biblioteca della Sezione di merceologia-Area tecnologia e valorizzazione risorse del Dipartimento di discipline economico-aziendali", #note storiche
"http://bigiavi.sba.unibo.it/", #sito web
44.49846458941028, #lat
11.351635352898189, #long
"Via delle Belle Arti", #indirizzo
"info.bigiavi@unibo.it" #email
);
#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#aggiungere campo numero?
#tabella GALLERIA
CREATE TABLE GALLERIA (
	NomeBiblioteca VARCHAR(50) PRIMARY KEY,
    FOREIGN KEY(NomeBiblioteca) REFERENCES BIBLIOTECA(Nome)
) ENGINE = InnoDB;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
INSERT INTO GALLERIA(NomeBiblioteca) VALUES ("Biblioteca Giuridica Antonio Cicu");
INSERT INTO GALLERIA(NomeBiblioteca) VALUES ("Biblioteca Giuseppe Testoni");
INSERT INTO GALLERIA(NomeBiblioteca) VALUES ("Biblioteca Nicola Matteucci");
INSERT INTO GALLERIA(NomeBiblioteca) VALUES ("Biblioteca del Dipartimento di Scienze economiche");

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella TELEFONO -> recapito telefonico
CREATE TABLE TELEFONO (
	NomeBiblioteca VARCHAR(50) PRIMARY KEY,
    FOREIGN KEY(NomeBiblioteca) REFERENCES BIBLIOTECA(Nome)
) ENGINE = InnoDB;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
INSERT INTO TELEFONO(NomeBiblioteca) VALUES ("Biblioteca Giuridica Antonio Cicu");
INSERT INTO TELEFONO(NomeBiblioteca) VALUES ("Biblioteca Giuseppe Testoni");
INSERT INTO TELEFONO(NomeBiblioteca) VALUES ("Biblioteca Nicola Matteucci");
INSERT INTO TELEFONO(NomeBiblioteca) VALUES ("Biblioteca del Dipartimento di Scienze economiche");

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella CARTACEO
CREATE TABLE CARTACEO (
	Codice INT AUTO_INCREMENT PRIMARY KEY,
    Titolo VARCHAR(100),
    ListaAutori VARCHAR(30),
    Genere VARCHAR(20),
    NomeEdizione VARCHAR(30),
    AnnoPubblicazione INT,
    StatoConservazione ENUM( 'Ottimo' , 'Buono' , 'Non Buono' , 'Scadente' ),
    StatoPrestito ENUM( 'Disponibile' , 'Prenotato' , 'Consegnato', 'Rimosso' ),
    NumeroPagine INT,
    NumeroScaffale INT,
    NomeBiblioteca VARCHAR(50),
    FOREIGN KEY(NomeBiblioteca) REFERENCES BIBLIOTECA(Nome)
) ENGINE = InnoDB;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#DELETE FROM CARTACEO;

#DROP TABLE CARTACEO;

#Biblioteca Giuridica Antonio Cicu
#Biblioteca Giuseppe Testoni
#Biblioteca Nicola Matteucci
#Biblioteca del Dipartimento di Scienze economiche

#1
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"Il Codice da Vinci", #Titolo
"Dan Brown", #lista autori
"Romanzo", #genere
"Prima edizione", #nome edizione
"2009", #anno pubblicazione
"Ottimo", #stato di conservazione,
"Disponibile", #stato prestito
300, #numero pagine,
2, #numero scaffale
"Biblioteca Giuseppe Testoni" #nome biblioteca
);

#1
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"Il Codice da Vinci", #Titolo
"Dan Brown", #lista autori
"Romanzo", #genere
"Prima edizione", #nome edizione
"2009", #anno pubblicazione
"Ottimo", #stato di conservazione,
"Disponibile", #stato prestito
300, #numero pagine,
2, #numero scaffale
"Biblioteca Giuridica Antonio Cicu" #nome biblioteca
);

#2
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"Il Codice da Vinci", #Titolo
"Dan Brown", #lista autori
"Romanzo", #genere
"Prima edizione", #nome edizione
"2009", #anno pubblicazione
"Ottimo", #stato di conservazione,
"Disponibile", #stato prestito
300, #numero pagine,
7, #numero scaffale
"Biblioteca Nicola Matteucci" #nome biblioteca
);

#3
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"L'alchimista", #Titolo
"Paulo Coelho", #lista autori
"Avventura", #genere
"Prima edizione", #nome edizione
"2011", #anno pubblicazione
"Non Buono", #stato di conservazione,
"Disponibile", #stato prestito
150, #numero pagine,
5, #numero scaffale
"Biblioteca del Dipartimento di Scienze economiche" #nome biblioteca
);

#4
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"Il giovane Holden", #Titolo
"J.D. Salinger ", #lista autori
"Fantasy", #genere
"Seconda edizione", #nome edizione
"2005", #anno pubblicazione
"Ottimo", #stato di conservazione,
"Disponibile", #stato prestito
348, #numero pagine,
9, #numero scaffale
"Biblioteca Giuseppe Testoni" #nome biblioteca
);

#5
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"Il leone, la strega e l’armadio", #Titolo
"C. S. Lewis", #lista autori
"Fiabesco", #genere
"Prima edizione", #nome edizione
"2020", #anno pubblicazione
"Buono", #stato di conservazione,
"Disponibile", #stato prestito
400, #numero pagine,
10, #numero scaffale
"Biblioteca Nicola Matteucci" #nome biblioteca
);

#6
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"Cinquanta sfumature di grigio", #Titolo
"E L James", #lista autori
"Romanzo", #genere
"Seconda edizione", #nome edizione
"2017", #anno pubblicazione
"Ottimo", #stato di conservazione,
"Disponibile", #stato prestito
229, #numero pagine,
4, #numero scaffale
"Biblioteca Nicola Matteucci" #nome biblioteca
);

#7
INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca) VALUES (
"Il Piccolo Principe", #Titolo
"Antoine de Saint-Exupéry", #lista autori
"Fiabesco", #genere
"Prima edizione", #nome edizione
"1999", #anno pubblicazione
"Non Buono", #stato di conservazione,
"Disponibile", #stato prestito
120, #numero pagine,
19, #numero scaffale
"Biblioteca del Dipartimento di Scienze economiche" #nome biblioteca
);

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella EBOOK
CREATE TABLE EBOOK (
	Codice INT AUTO_INCREMENT PRIMARY KEY,
    Titolo VARCHAR(30),
    ListaAutori VARCHAR(30),
    Genere VARCHAR(20),
    NomeEdizione VARCHAR(20),
    AnnoPubblicazione INT,
    PDF VARCHAR(30),
    NrAccessi INT,
    Dimensione INT,
    NomeBiblioteca VARCHAR(100),
    FOREIGN KEY(NomeBiblioteca) REFERENCES BIBLIOTECA(Nome)
) ENGINE = InnoDB;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
#DELETE FROM EBOOK;

#DROP TABLE EBOOK;

#Biblioteca Giuridica Antonio Cicu
#Biblioteca Giuseppe Testoni
#Biblioteca Nicola Matteucci
#Biblioteca del Dipartimento di Scienze economiche

#1
INSERT INTO EBOOK(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, PDF, NrAccessi, Dimensione, NomeBiblioteca) VALUES (
"Il sogno della camera rossa", #Titolo
"Ts'ao Hsueh-ch'in", #lista autori
"Fantascienza", #genere
"Seconda edizione", #nome edizione
"2001", #anno pubblicazione
"CameraRossa.pdf", #PDF
0, #NrAccessi
10,#Dimensione
"Biblioteca Giuridica Antonio Cicu" #nome biblioteca
);

#2
INSERT INTO EBOOK(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, PDF, NrAccessi, Dimensione, NomeBiblioteca) VALUES (
"Il Signore degli Anelli", #Titolo
"J.R.R. Tolkien", #lista autori
"Fantascienza", #genere
"Prima edizione", #nome edizione
"2009", #anno pubblicazione
"SignoreAnelli.pdf", #PDF
0, #NrAccessi
60,#Dimensione
"Biblioteca Giuseppe Testoni" #nome biblioteca
);

#3
INSERT INTO EBOOK(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, PDF, NrAccessi, Dimensione, NomeBiblioteca) VALUES (
"Dieci piccoli indiani", #Titolo
"Agatha Christie", #lista autori
"Romanzo", #genere
"Seconda edizione", #nome edizione
"2000", #anno pubblicazione
"PiccoliIndiani.pdf", #PDF
0, #NrAccessi
45,#Dimensione
"Biblioteca del Dipartimento di Scienze economiche" #nome biblioteca
);

#4
INSERT INTO EBOOK(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, PDF, NrAccessi, Dimensione, NomeBiblioteca) VALUES (
"Fu sera e fu mattina", #Titolo
"Ken Follett", #lista autori
"Avventura", #genere
"Prima edizione", #nome edizione
"2018", #anno pubblicazione
"MattinaSera.pdf", #PDF
0, #NrAccessi
20,#Dimensione
"Biblioteca Giuseppe Testoni" #nome biblioteca
);

#5
INSERT INTO EBOOK(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, PDF, NrAccessi, Dimensione, NomeBiblioteca) VALUES (
"Le ali del sogno", #Titolo
"Daydreamer", #lista autori
"Diario", #genere
"Seconda edizione", #nome edizione
"2015", #anno pubblicazione
"AcquaFiori.pdf", #PDF
0, #NrAccessi
90,#Dimensione
"Biblioteca Giuridica Antonio Cicu" #nome biblioteca
);

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella POSTOLETTURA
CREATE TABLE POSTOLETTURA (
	Numero INT,
	NomeBiblioteca VARCHAR(50),
    PresaCorrente BOOLEAN,
    PresaEthernet BOOLEAN,
    PRIMARY KEY(Numero, NomeBiblioteca),
    FOREIGN KEY(NomeBiblioteca) REFERENCES BIBLIOTECA(Nome)
) ENGINE = InnoDB;
#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
1, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
TRUE, #corrente,
FALSE #rete
);

INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
2, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
FALSE, #corrente,
TRUE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
3, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
TRUE, #corrente,
FALSE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
4, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
FALSE, #corrente,
TRUE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
5, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
FALSE, #corrente,
FALSE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
6, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
FALSE, #corrente,
FALSE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
7, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
TRUE, #corrente,
FALSE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
8, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
TRUE, #corrente,
FALSE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
9, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
FALSE, #corrente,
TRUE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
10, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
TRUE, #corrente,
TRUE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
11, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
TRUE, #corrente,
TRUE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
12, #numero
"Biblioteca Giuridica Antonio Cicu", #nome biblioteca
TRUE, #corrente,
FALSE #rete
);

INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
1, #numero
"Biblioteca Giuseppe Testoni", #nome biblioteca
TRUE, #corrente,
FALSE #rete
);
INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
2, #numero
"Biblioteca Giuseppe Testoni", #nome biblioteca
FALSE, #corrente,
FALSE #rete
);

INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
3, #numero
"Biblioteca Giuseppe Testoni", #nome biblioteca
TRUE, #corrente,
TRUE #rete
);

INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
4, #numero
"Biblioteca Giuseppe Testoni", #nome biblioteca
FALSE, #corrente,
TRUE #rete
);

INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
5, #numero
"Biblioteca Giuseppe Testoni", #nome biblioteca
FALSE, #corrente,
TRUE #rete
);

INSERT INTO POSTOLETTURA(Numero, NomeBiblioteca, PresaCorrente, PresaEthernet) VALUES(
1, #numero
"Biblioteca del Dipartimento di Scienze economiche", #nome biblioteca
FALSE, #corrente,
FALSE #rete
);

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella AMMINISTRATORE
CREATE TABLE AMMINISTRATORE (
	Email VARCHAR(50) PRIMARY KEY,
    Psw VARCHAR(30),
    Cognome VARCHAR(20),
    Nome VARCHAR(20),
    LuogoNascita VARCHAR(20),
    DataNascita DATE,
    RecapitoTelefonico INT,
    Qualifica VARCHAR(10),
    NomeBiblioteca VARCHAR(50),
    FOREIGN KEY(NomeBiblioteca) REFERENCES BIBLIOTECA(Nome)
) ENGINE = InnoDB;

#DROP TABLE AMMINISTRATORE;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
INSERT INTO AMMINISTRATORE(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  Qualifica, NomeBiblioteca) VALUES (
"luca.linari@gmail.com", #email
"luca1", #password
"Linari", #cognome,
"Luca", #nome
"New York", #luogoNascita
'1999-09-01',#dataNascita
339, #numero di telefono
"Tecnico", #qualifica
"Biblioteca del Dipartimento di Scienze economiche" #nome biblio
);

INSERT INTO AMMINISTRATORE(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  Qualifica, NomeBiblioteca) VALUES (
"dario.zecchin@gmail.com", #email
"dario", #password
"Zecchin", #cognome,
"Dario", #nome
"Parigi", #luogoNascita
'1999-01-01',#dataNascita
598, #numero di telefono
"Gestione", #qualifica
"Biblioteca Giuseppe Testoni" #nome biblio
);

INSERT INTO AMMINISTRATORE(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  Qualifica, NomeBiblioteca) VALUES (
"alessandro.rossi@gmail.com", #email
"alessandro", #password
"Rossi", #cognome,
"Alessandro", #nome
"Parigi", #luogoNascita
'1998-11-11',#dataNascita
302, #numero di telefono
"Tecnico", #qualifica
"Biblioteca Giuridica Antonio Cicu" #nome biblio
);

INSERT INTO AMMINISTRATORE(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  Qualifica, NomeBiblioteca) VALUES (
"francesca.rossi@gmail.com", #email
"francescaAmm", #password
"Rossi", #cognome,
"Francesca", #nome
"Bologna", #luogoNascita
'1948-2-11',#dataNascita
849, #numero di telefono
"Gestione", #qualifica
"Biblioteca di discipline umanistiche " #nome biblio
);

INSERT INTO AMMINISTRATORE(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  Qualifica, NomeBiblioteca) VALUES (
"letizia.rossi@gmail.com", #email
"letiziaAmm", #password
"Rossi", #cognome,
"Letizia", #nome
"Bologna", #luogoNascita
'1978-3-11',#dataNascita
849, #numero di telefono
"Gestione", #qualifica
"Biblioteca Nicola Matteucci " #nome biblio
);
#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella VOLONTARIO
CREATE TABLE VOLONTARIO (
	Email VARCHAR(50) PRIMARY KEY,
    Psw VARCHAR(30),
    Cognome VARCHAR(20),
    Nome VARCHAR(20),
    LuogoNascita VARCHAR(20),
    DataNascita DATE,
    RecapitoTelefonico INT,
    MezzoTrasporto ENUM( 'Piedi' , 'Bici' , 'Auto' )
) ENGINE = InnoDB;

#DROP TABLE VOLONTARIO;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO VOLONTARIO(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  MezzoTrasporto) VALUES (
"marco.rossi@gmail.com", #email
"marcoVol", #password
"Rossi", #cognome,
"Marco", #nome
"Bergamo", #luogoNascita
'1990-5-20',#dataNascita
213, #numero di telefono
"Piedi"
);

INSERT INTO VOLONTARIO(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  MezzoTrasporto) VALUES (
"franco.rossi@gmail.com", #email
"francoVol", #password
"Rossi", #cognome,
"Franco", #nome
"Napoli", #luogoNascita
'1978-4-5',#dataNascita
111, #numero di telefono
"Auto"
);

INSERT INTO VOLONTARIO(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  MezzoTrasporto) VALUES (
"stefano.rossi@gmail.com", #email
"stefanoVol", #password
"Rossi", #cognome,
"Stefano", #nome
"Catania", #luogoNascita
'1958-1-20',#dataNascita
999, #numero di telefono
"Bici"
);

INSERT INTO VOLONTARIO(Email, Psw,Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  MezzoTrasporto) VALUES (
"alice.rossi@gmail.com", #email
"aliceVol", #password
"Rossi", #cognome,
"Alice", #nome
"Milano", #luogoNascita
'1980-8-20',#dataNascita
456, #numero di telefono
"Auto"
);

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella UTILIZZATORE
CREATE TABLE UTILIZZATORE (
	Email VARCHAR(60) PRIMARY KEY,
    Psw VARCHAR(30),
    Cognome VARCHAR(20),
    Nome VARCHAR(20),
    LuogoNascita VARCHAR(20),
    DataNascita DATE,
    RecapitoTelefonico INT,
    DataAccount DATE,
    StatoAccount ENUM( 'Attivo' , 'Sospeso' ),
    CampoProfessione VARCHAR(50)
) ENGINE = InnoDB;

#DROP TABLE UTILIZZATORE;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

INSERT INTO UTILIZZATORE(Email, Psw, Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  DataAccount, StatoAccount, CampoProfessione) VALUES (
"giallo.giovanni@gmail.com", #email
"giallino", #password
"Giallo", #cognome,
"Giovanni", #nome
"Roma", #luogoNascita
'1980-8-20',#dataNascita
598, #numero di telefono
'2020-03-10',#data account
"Attivo",#stato account
"Disoccupato"#campo professione
);

INSERT INTO UTILIZZATORE(Email, Psw, Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  DataAccount, StatoAccount, CampoProfessione) VALUES (
"rosso.gianfranco@gmail.com", #email
"rossino", #password
"Rosso", #cognome,
"Gianfranco", #nome
"Napoli", #luogoNascita
'1990-1-20',#dataNascita
568, #numero di telefono
'2020-07-10',#data account
"Sospeso",#stato account
"Consulente finanziario"#campo professione
);

INSERT INTO UTILIZZATORE(Email, Psw, Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  DataAccount, StatoAccount, CampoProfessione) VALUES (
"sofia.rossi@gmail.com", #email
"sofiaUti", #password
"Rossi", #cognome,
"Sofia", #nome
"Firenze", #luogoNascita
'1990-4-10',#dataNascita
394, #numero di telefono
'2020-09-15',#data account
"Attivo",#stato account
"Scienziato"#campo professione
);

INSERT INTO UTILIZZATORE(Email, Psw, Cognome, Nome, LuogoNascita, DataNascita, RecapitoTelefonico,  DataAccount, StatoAccount, CampoProfessione) VALUES (
"viola.chiara@gmail.com", #email
"violaUti", #password
"Viola", #cognome,
"Chiara", #nome
"Torino", #luogoNascita
'1997-3-30',#dataNascita
394, #numero di telefono
'2020-09-15',#data account
"Attivo",#stato account
"Avvocato"#campo professione
);


#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella PRENOTAZIONEPOSTO
CREATE TABLE PRENOTAZIONEPOSTO (
	NomeBibliotecaPostoLettura VARCHAR(50),
    NumeroPostoLettura INT ,
    EmailUtilizzatore VARCHAR(50),
    DataPrenotazione DATE,
    OraInizio TIME,
    OraFine TIME,
    PRIMARY KEY(NomeBibliotecaPostoLettura,DataPrenotazione, EmailUtilizzatore, OraFIne),
    FOREIGN KEY(EmailUtilizzatore) REFERENCES UTILIZZATORE(Email),
    FOREIGN KEY(NumeroPostoLettura) REFERENCES POSTOLETTURA(Numero),
    FOREIGN KEY(NomeBibliotecaPostoLettura) REFERENCES POSTOLETTURA(NomeBiblioteca)
) ENGINE = InnoDB;

#DROP TABLE PRENOTAZIONEPOSTO;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella LETTURA
CREATE TABLE LETTURA (
    Codice INT AUTO_INCREMENT NOT NULL,
	CodiceEbook INT,
    EmailUtilizzatore VARCHAR(50),
    PRIMARY KEY(Codice),
    FOREIGN KEY(CodiceEbook) REFERENCES EBOOK(Codice),
    FOREIGN KEY(EmailUtilizzatore) REFERENCES UTILIZZATORE(Email)
) ENGINE = InnoDB;

#DROP TABLE LETTURA;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella PRENOTAZIONELIBRO
CREATE TABLE PRENOTAZIONELIBRO (
	Codice INT AUTO_INCREMENT PRIMARY KEY,
    DataAvvio DATE,
	DataFine DATE,
    CodiceCartaceo INT,
    EmailUtilizzatore VARCHAR(50),
	FOREIGN KEY(CodiceCartaceo) REFERENCES CARTACEO(Codice),
    FOREIGN KEY(EmailUtilizzatore) REFERENCES UTILIZZATORE(Email)
) ENGINE = InnoDB;

#DROP TABLE PRENOTAZIONELIBRO;

#DELETE FROM PRENOTAZIONELIBRO;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella EVENTOCONSEGNA
CREATE TABLE EVENTOCONSEGNA (
	Codice INT AUTO_INCREMENT PRIMARY KEY,
	CodicePrenotazioneLibro INT,
    EmailVolontario VARCHAR(50),
    DataConsegna DATE,
    Tipo ENUM( 'Restituzione' , 'Affidamento' ),
    Note VARCHAR(200), #scritto nel testo di 200
    FOREIGN KEY(CodicePrenotazioneLibro) REFERENCES PRENOTAZIONELIBRO(Codice),
    FOREIGN KEY(EmailVolontario) REFERENCES VOLONTARIO(Email)
) ENGINE = InnoDB;

#DROP TABLE EVENTOCONSEGNA;


#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


#tabella SEGNALAZIONE
CREATE TABLE SEGNALAZIONE (
	EmailUtilizzatore VARCHAR(50),
    NrSegnalazione INT,
    DataSegnalazione DATE,
    Testo VARCHAR(100),
    EmailAmministratore VARCHAR(50),
    PRIMARY KEY(EmailUtilizzatore, NrSegnalazione),
    FOREIGN KEY(EmailUtilizzatore) REFERENCES UTILIZZATORE(Email),
    FOREIGN KEY(EmailAmministratore) REFERENCES AMMINISTRATORE(Email)
) ENGINE = InnoDB;

#DROP TABLE SEGNALAZIONE;

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#tabella MESSAGGIO
CREATE TABLE MESSAGGIO (
	Codice INT AUTO_INCREMENT PRIMARY KEY,
    Titolo VARCHAR(20),
    Testo VARCHAR(500),
    DataMessaggio DATE,
	EmailAmministratore VARCHAR(50),
    EmailUtilizzatore VARCHAR(50),
    FOREIGN KEY(EmailUtilizzatore) REFERENCES UTILIZZATORE(Email),
    FOREIGN KEY(EmailAmministratore) REFERENCES AMMINISTRATORE(Email)
) ENGINE = InnoDB;

#DROP TABLE MESSAGGIO;

#DELETE FROM MESSAGGIO;

#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

#----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
