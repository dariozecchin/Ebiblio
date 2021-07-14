DELIMITER |
CREATE PROCEDURE VisualizzaBiblioteche()

BEGIN
    START TRANSACTION;
    SELECT *
    FROM BIBLIOTECA
    COMMIT ;
    END |

DELIMITER ;

#ok
##########################################################

DELIMITER |
CREATE PROCEDURE NumeroPostiLetturaBiblioteca()

BEGIN

    START TRANSACTION;

	SELECT BIBLIOTECA.Nome, COUNT(*) AS NrPostiLettura
    FROM BIBLIOTECA JOIN POSTOLETTURA ON (BIBLIOTECA.Nome = POSTOLETTURA.NomeBiblioteca)
    GROUP BY BIBLIOTECA.Nome
    ORDER BY NrPostiLettura DESC;


    COMMIT ;
    END |

DELIMITER ;

#ok
#########################################################

DELIMITER |
CREATE PROCEDURE LibriDisponibili()

BEGIN
    SELECT DISTINCT Codice, Titolo, ListaAutori, Genere,
        NomeEdizione, AnnoPubblicazione, NumeroPagine, NumeroScaffale, NomeBiblioteca
    FROM CARTACEO
    WHERE CARTACEO.StatoPrestito = 'Disponibile' AND StatoConservazione<>'Non Buono';
END |

DELIMITER ;

#ok
###############################################################
DROP PROCEDURE
DELIMITER |
CREATE PROCEDURE ClassificaVolontari()

BEGIN

    START TRANSACTION;


    SELECT DISTINCT VOLONTARIO.Email, COUNT(*) AS NrConsegne
    FROM VOLONTARIO JOIN EVENTOCONSEGNA ON (VOLONTARIO.Email = EVENTOCONSEGNA.EmailVolontario)
    GROUP BY VOLONTARIO.Email
    ORDER BY NrConsegne DESC
    LIMIT 10;



    COMMIT ;
    END |

DELIMITER ;
#ok
################################################################################

DELIMITER |
CREATE PROCEDURE ClassificaCartacei()

BEGIN
    START TRANSACTION;

    SELECT DISTINCT CARTACEO.Titolo, COUNT(*) as NrPrenotazioni
    FROM CARTACEO JOIN PRENOTAZIONELIBRO ON (CARTACEO.Codice = PRENOTAZIONELIBRO.CodiceCartaceo)
    GROUP BY CARTACEO.Titolo
    ORDER BY NrPrenotazioni DESC
    LIMIT 10;

    COMMIT ;
    END |


DELIMITER ;

#ok
###############################################################################

DELIMITER |
CREATE PROCEDURE ClassificaEbook()


BEGIN

    START TRANSACTION;

    SELECT * FROM EBOOK
    ORDER BY NrAccessi DESC
    LIMIT 10;
    COMMIT ;
    END |

DELIMITER ;

#ok
##########################################################################

DELIMITER |
CREATE PROCEDURE AggiornamentoEventoConsegna(IN CodiceP INT, IN EmailV VARCHAR(100), IN DataV DATE, TipoV ENUM('Restituzione', 'Affidamento'), IN NoteV VARCHAR(100))

EGIN
    IF (DataV>=CURDATE()) THEN
    UPDATE EVENTOCONSEGNA SET EVENTOCONSEGNA.EmailVolontario = EmailV,
														EVENTOCONSEGNA.DataConsegna = DataV,
                                                        EVENTOCONSEGNA.Note = NoteV
													    WHERE EVENTOCONSEGNA.CodicePrenotazioneLibro = CodiceP AND TipoV=Tipo;
        END IF;
    END |
DELIMITER ;

#ok
####################################################################################

##############################################################

DELIMITER $
CREATE PROCEDURE CatalogaLibro(IN Title VARCHAR(100), IN Autori VARCHAR(30), IN Genre VARCHAR(20), IN Edizioni VARCHAR(30), IN Anno INT, IN Stato VARCHAR(20), IN Prestito VARCHAR(20), IN Pagine INT, IN Scaffale INT, IN EmailA VARCHAR(50))
BEGIN
	DECLARE B VARCHAR(100);
    SET B = (SELECT NomeBiblioteca FROM AMMINISTRATORE WHERE Email=EmailA);
	INSERT INTO CARTACEO(Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca)
    VALUES (Title, Autori, Genre, Edizioni, Anno, Stato, Prestito, Pagine, Scaffale, B);
END $

#ok
###################################


DELIMITER $
CREATE PROCEDURE EliminaLibro(IN C INT)
BEGIN
	UPDATE CARTACEO SET StatoPrestito='Rimosso', NumeroScaffale=0 WHERE (Codice = C);
END $
DELIMITER;

#ok
#################################################################

DELIMITER $
CREATE PROCEDURE AggiornamentoLibro(IN Cc INT, IN Title VARCHAR(100), IN Autori VARCHAR(30), IN Genre VARCHAR(20), IN Edizioni VARCHAR(30), IN Anno INT, IN Stato VARCHAR(20), IN Prestito VARCHAR(20), IN Pagine INT, IN Scaffale INT, IN Biblioteca VARCHAR(50))
BEGIN
	UPDATE CARTACEO
		SET Titolo = Title, ListaAutori = Autori, Genere = Genre, NomeEdizione = Edizioni, AnnoPubblicazione = Anno, StatoConservazione = Stato, StatoPrestito = Prestito, NumeroPagine = Pagine, NumeroScaffale = Scaffale, NomeBiblioteca = Biblioteca
			WHERE Codice = Cc;
END $
DELIMITER;

#ok
#####################################################################

DELIMITER $
CREATE PROCEDURE PrenotazioneBiblioteca(IN EmailA VARCHAR(50))
BEGIN
	DECLARE BibliotecaAmm VARCHAR(50);
    SET BibliotecaAmm = (SELECT NomeBiblioteca FROM AMMINISTRATORE WHERE (Email = EmailA));

	SELECT PRENOTAZIONELIBRO.Codice, PRENOTAZIONELIBRO.DataAvvio, PRENOTAZIONELIBRO.DataFine, PRENOTAZIONELIBRO.CodiceCartaceo, PRENOTAZIONELIBRO.EmailUtilizzatore
		FROM PRENOTAZIONELIBRO JOIN CARTACEO
			ON (PRENOTAZIONELIBRO.CodiceCartaceo = CARTACEO.Codice)
				WHERE NomeBiblioteca = BibliotecaAmm;

END $
DELIMITER;

#ok
#############################################################


DELIMITER $
CREATE PROCEDURE PostiBibliotecaStorico(IN EmailA VARCHAR(50))
BEGIN
    SELECT * FROM PRENOTAZIONEPOSTO WHERE PRENOTAZIONEPOSTO.NomeBibliotecaPostoLettura IN
    (SELECT AMMINISTRATORE.NomeBiblioteca FROM AMMINISTRATORE WHERE EmailA=Email);
END $

DELIMITER;

#ok
###################################################################################################

DELIMITER $
CREATE PROCEDURE MandaMessaggio(IN Title VARCHAR(100), IN Testo1 VARCHAR(100), IN DataMex DATE, IN EmailA VARCHAR(30), IN EmailU VARCHAR(30))
BEGIN
	INSERT INTO MESSAGGIO(Titolo, Testo, DataMessaggio, EmailAmministratore, EmailUtilizzatore)
    VALUES (Title, Testo1, DataMex, EmailA, EmailU);
END $
DELIMITER;

#ok
######################################################################################################

DELIMITER |
CREATE PROCEDURE InviaSegnalazione(IN EmailU VARCHAR(100), IN Testo1 VARCHAR(200), IN EmailAmm VARCHAR(100))
BEGIN
	DECLARE str VARCHAR(100);
	DECLARE x INT;

    SET x = (SELECT COUNT(*) FROM SEGNALAZIONE WHERE EmailUtilizzatore = EmailU);
    IF (x<3) THEN
		SET x = x + 1;
		INSERT INTO SEGNALAZIONE(EmailUtilizzatore, NrSegnalazione, DataSegnalazione, Testo, EmailAmministratore)
        VALUES (EmailU, x, CURDATE(), Testo1, EmailAmm);
	END IF;
END |

#ok
#################################################################################################################


DELIMITER $
CREATE PROCEDURE RimuoviSegnalazione(IN EmailU VARCHAR(50))
BEGIN
		DELETE FROM SEGNALAZIONE WHERE (EmailUtilizzatore = EmailU);
        UPDATE UTILIZZATORE SET StatoAccount = 'Attivo' WHERE Email = EmailU;
END $
DELIMITER;

#ok
#######################################################
DELIMITER //
CREATE Procedure PrenotaLibro ( IN p_codice int, IN  p_emailUtilizzatore VARCHAR(60))

BEGIN
    DECLARE P VARCHAR(20);
    DECLARE C VARCHAR(20);
	set P =(SELECT StatoPrestito
        FROM CARTACEO
            WHERE (Codice = p_codice));
    SET C = (SELECT StatoConservazione FROM CARTACEO WHERE (Codice = p_codice));
    IF (P='Disponibile' AND C<>'Non Buono') THEN
        INSERT INTO PRENOTAZIONELIBRO (DataAvvio , DataFine, CodiceCartaceo , EmailUtilizzatore )
        VALUES(NOW() ,DATE_ADD(now(), INTERVAL 15 DAY),  p_codice, p_emailUtilizzatore );
    END IF;
END //
DELIMITER;

#ok
###################################################################################################

DELIMITER //

CREATE Procedure PrenotazioniLibroUtilizzatore ( IN p_emailUtilizzatore VARCHAR(60))

BEGIN

SELECT * from prenotazionelibro where ( emailUtilizzatore = p_emailUtilizzatore ) ;

END //
DELIMITER;

#ok
#################################################################

DELIMITER //
CREATE Procedure PostoPrenotatoUtilizzatore ( IN p_emailUtilizzatore VARCHAR(60))

BEGIN

SELECT * from prenotazioneposto where ( emailUtilizzatore = p_emailUtilizzatore ) ;


END //
DELIMITER;

#ok
###################################################################################################################################

DELIMITER //

CREATE Procedure VisualizzaEbook (IN p_codice INT, IN EmailU VARCHAR(50))

BEGIN
	SELECT * from ebook where ( codice = p_codice ) ;
    INSERT LETTURA(CodiceEbook, EmailUtilizzatore) VALUES(p_codice,EmailU);
END //
DELIMITER;

#ok
###########################################################################################################################

DELIMITER //
CREATE PROCEDURE BibliotecheMenoUtilizzate()
BEGIN
CREATE VIEW PT AS SELECT NomeBiblioteca, COUNT(*) AS PostiTotali FROM POSTOLETTURA GROUP BY NomeBiblioteca;
CREATE VIEW OCC AS SELECT NomeBibliotecaPostoLettura, COUNT(*) AS PostiPrenotati FROM PRENOTAZIONEPOSTO GROUP BY NomeBibliotecaPostoLettura;
SELECT NomeBiblioteca FROM PT JOIN OCC ON NomeBiblioteca=NomeBibliotecaPostoLettura ORDER BY PostiTotali/PostiPrenotati DESC;
DROP VIEW PT;
DROP VIEW OCC;
END //
DELIMITER;

#ok
####################################################################################

DELIMITER $
CREATE PROCEDURE PrenotazioniLibriAttive(IN EmailU VARCHAR(50))
BEGIN
	SELECT * FROM PRENOTAZIONELIBRO WHERE CURDATE()<=DataFine AND EmailUtilizzatore=EmailU;
END $
DELIMITER;

#ok
#####################################################################################

DELIMITER $
CREATE PROCEDURE PostiPrenotatiAttivi(IN EmailU VARCHAR(50))
BEGIN
	SELECT NomeBibliotecaPostoLettura, NumeroPostoLettura, DataPrenotazione, OraInizio, OraFine
    FROM PRENOTAZIONEPOSTO
    WHERE (EmailUtilizzatore=EmailU) AND (CURDATE()<=DataPrenotazione);
END $
DELIMITER;

#ok
########################################################################################

DELIMITER $
CREATE PROCEDURE EventiConsegnaAttivi(IN EmailU VARCHAR(50))
BEGIN
	#METTERE IN ORDER BY DISC QUELLA STORICA
	SELECT *
    FROM EVENTOCONSEGNA
    WHERE CURDATE()<=DataConsegna AND EVENTOCONSEGNA.CodicePrenotazioneLibro IN (
    SELECT PRENOTAZIONELIBRO.Codice FROM PRENOTAZIONELIBRO WHERE EmailUtilizzatore=EmailU);
END $
DELIMITER;

#ok
###########################################################################################################################

DELIMITER $
CREATE PROCEDURE PrenotazioniVolAttive(IN EmailV VARCHAR(50))
#DUBBI SULLA QUERY
BEGIN
	SELECT PRENOTAZIONELIBRO.Codice AS CodicePrenotazioneLibro, DataConsegna, CodiceCartaceo, EmailUtilizzatore, Tipo, Note
    FROM PRENOTAZIONELIBRO, EVENTOCONSEGNA
    WHERE EmailV=EmailVolontario AND PRENOTAZIONELIBRO.Codice=EVENTOCONSEGNA.CodicePrenotazioneLibro AND CURDATE()<=DataConsegna;
END $
DELIMITER;

#ok
###########################################################################################################################

DELIMITER $
CREATE PROCEDURE PrenotazioniLibriAmministratoreAttive(IN EmailA VARCHAR(50))
BEGIN
	DECLARE BibliotecaAmm VARCHAR(50);
    SET BibliotecaAmm = (SELECT NomeBiblioteca FROM AMMINISTRATORE WHERE (Email = EmailA));

	SELECT PRENOTAZIONELIBRO.Codice, PRENOTAZIONELIBRO.DataAvvio, PRENOTAZIONELIBRO.DataFine, PRENOTAZIONELIBRO.CodiceCartaceo, PRENOTAZIONELIBRO.EmailUtilizzatore
		FROM PRENOTAZIONELIBRO JOIN CARTACEO
			ON (PRENOTAZIONELIBRO.CodiceCartaceo = CARTACEO.Codice)
				WHERE NomeBiblioteca = BibliotecaAmm AND CURDATE()<=DataFine;

END $
DELIMITER;

#ok
###########################################################################################################################

DELIMITER $
CREATE PROCEDURE VolontarioDelMese()
BEGIN
	SELECT EmailVolontario, COUNT(*) AS NumeroConsegne FROM EVENTOCONSEGNA WHERE (NOW()-INTERVAL 1 MONTH)<EVENTOCONSEGNA.DataConsegna AND CURDATE()>=DataConsegna
    GROUP BY EmailVolontario ORDER BY NumeroConsegne DESC LIMIT 10;
END $
DELIMITER;

#ok
###########################################################################################################################

DELIMITER $
CREATE PROCEDURE LibroDelMese()
BEGIN
	SELECT DISTINCT CARTACEO.Titolo, COUNT(*) as NrPrenotazioni
    FROM CARTACEO JOIN PRENOTAZIONELIBRO ON (CARTACEO.Codice = PRENOTAZIONELIBRO.CodiceCartaceo)
    WHERE CURDATE()<=DataFine
    GROUP BY CARTACEO.Titolo
    ORDER BY NrPrenotazioni DESC
    LIMIT 10;
END $
DELIMITER;

#ok
###########################################################################################################################

DELIMITER $
CREATE PROCEDURE PrenotaPosto(IN NomeB VARCHAR(100), IN EmailU VARCHAR(100), IN Dat DATE, IN OraI TIME, IN OraF TIME, IN Corrente BOOLEAN, IN Ethernet BOOLEAN)
BEGIN
    DECLARE TIM TIME;
    DECLARE X INT;
    DECLARE I INT;
    DECLARE Fine TIME;
    DECLARE Inizio TIME;
    DECLARE Nr INT;
    DECLARE Posto INT;

    SET TIM = TIMEDIFF(OraF, OraI);
    SET X = ((TIME_TO_SEC(TIM)/60)/60);
    SET I = 1;
    SET Fine = OraI;
    SET Inizio = OraI;

    SET Posto = (SELECT Numero FROM POSTOLETTURA WHERE (NomeBiblioteca=NomeB) AND (PresaCorrente=Corrente) AND (PresaEthernet=Ethernet) AND Numero NOT IN
        (SELECT NumeroPostoLettura FROM PRENOTAZIONEPOSTO WHERE (OraI<OraFine) AND NumeroPostoLettura IN
            (SELECT NumeroPostoLettura FROM PRENOTAZIONEPOSTO WHERE (NomeBibliotecaPostoLettura=NomeB) AND (OraF>OraInizio) AND (OraF<=OraFine) AND (Dat=DataPrenotazione))) # forse da mettere AND (OraI<OraFine)
    ORDER BY Numero LIMIT 1);

        WHILE (I<=X) DO
            SET Fine = ADDTIME(Fine,'01:00:00');
            INSERT INTO PRENOTAZIONEPOSTO(NomeBibliotecaPostoLettura, NumeroPostoLettura, EmailUtilizzatore, DataPrenotazione, OraInizio, OraFine) VALUES(
                NomeB, Posto, EmailU, Dat, Inizio, Fine);
                SET I = I+1;
                SET Inizio = ADDTIME(Inizio,'01:00:00');
        END WHILE;
END $
DELIMITER;

#ok
###########################################################################################################################

DELIMITER $
CREATE PROCEDURE EventiConsegnaUtilizzatore(IN EmailU VARCHAR(50))
BEGIN
    SELECT *
    FROM EVENTOCONSEGNA
    WHERE EVENTOCONSEGNA.CodicePrenotazioneLibro IN (
    SELECT PRENOTAZIONELIBRO.Codice FROM PRENOTAZIONELIBRO WHERE EmailUtilizzatore=EmailU);
END $

#ok
###########################################################################################################################

DELIMITER |
CREATE Procedure RegistrazioneVolontario ( IN p_EMAIL VARCHAR(60), IN p_PSW VARCHAR(30) , IN p_COGNOME VARCHAR(20) ,
 IN p_NOME VARCHAR(20) , IN p_LUOGONASCITA VARCHAR(20), IN p_DATANASCITA DATE, IN p_RECAPITOTELEFONICO INT, IN p_MEZZO VARCHAR(50))

BEGIN

	 DECLARE checkVolontario INT;
     DECLARE checkUtilizzatore INT;
     DECLARE checkAmministratore INT;

	START TRANSACTION;



	SET checkVolontario = (
	SELECT COUNT(*)
	FROM VOLONTARIO
	WHERE VOLONTARIO.Email IN (p_EMAIL));

	SET checkUtilizzatore = (
	SELECT COUNT(*)
	FROM UTILIZZATORE
	WHERE UTILIZZATORE.Email IN (p_EMAIL));

	SET checkAmministratore = (
	SELECT COUNT(*)
	FROM AMMINISTRATORE
	WHERE AMMINISTRATORE.Email IN (p_EMAIL));

    IF(checkVolontario = 0 AND checkUtilizzatore = 0 AND checkAmministratore = 0) THEN
    INSERT INTO VOLONTARIO ( EMAIL, PSW  ,COGNOME ,
    NOME  ,LUOGONASCITA,  DATANASCITA, RECAPITOTELEFONICO  , MEZZOTRASPORTO ) values ( p_EMAIL, p_PSW  ,p_COGNOME ,
    p_NOME  ,p_LUOGONASCITA,  p_DATANASCITA, p_RECAPITOTELEFONICO  ,p_MEZZO);

    ELSE

    SELECT  "L'email che vuoi inserire è già stata usata da qualche utente";

 END IF;

COMMIT ;
END |

#ok
###########################################################################################################################
DELIMITER |
CREATE Procedure RegistrazioneUtente ( IN p_EMAIL VARCHAR(60), IN p_PSW VARCHAR(30) , IN p_COGNOME VARCHAR(20) ,
 IN p_NOME VARCHAR(20) , IN p_LUOGONASCITA VARCHAR(20), IN p_DATANASCITA DATE, IN p_RECAPITOTELEFONICO INT , IN p_CampoProfessione VARCHAR(50))

BEGIN

	 DECLARE checkVolontario INT;
     DECLARE checkUtilizzatore INT;
     DECLARE checkAmministratore INT;

	START TRANSACTION;


	SET checkVolontario = (
	SELECT COUNT(*)
	FROM VOLONTARIO
	WHERE VOLONTARIO.Email IN (p_EMAIL));

	SET checkUtilizzatore = (
	SELECT COUNT(*)
	FROM UTILIZZATORE
	WHERE UTILIZZATORE.Email IN (p_EMAIL));

	SET checkAmministratore = (
	SELECT COUNT(*)
	FROM AMMINISTRATORE
	WHERE AMMINISTRATORE.Email IN (p_EMAIL));

    IF(checkVolontario = 0 AND checkUtilizzatore = 0 AND checkAmministratore = 0) THEN
    INSERT INTO UTILIZZATORE ( EMAIL, PSW  ,COGNOME ,
    NOME  ,LUOGONASCITA,  DATANASCITA, RECAPITOTELEFONICO  ,  DataAccount,
    StatoAccount , CampoProfessione ) values ( p_EMAIL, p_PSW  ,p_COGNOME ,
    p_NOME  ,p_LUOGONASCITA,  p_DATANASCITA, p_RECAPITOTELEFONICO  ,  CURDATE(),
    'Attivo' , p_CampoProfessione);

    ELSE

    SELECT  "L'email che vuoi inserire è già stata usata da qualche utente";

 END IF;

COMMIT ;
END |

#ok
###########################################################################################################################

DELIMITER $
CREATE PROCEDURE PostiBibliotecaAttivi(IN EmailA VARCHAR(50))
BEGIN
    SELECT NomeBiblioteca AS Biblioteca, NumeroPostoLettura AS NumeroPosto, EmailUtilizzatore, DataPrenotazione, OraInizio, OraFine
    FROM PRENOTAZIONEPOSTO JOIN AMMINISTRATORE ON NomeBibliotecaPostoLettura=NomeBiblioteca
    WHERE EmailA=AMMINISTRATORE.Email AND CURDATE()<=DataPrenotazione;
END $

#ok
###########################################################################################################################
DELIMITER $
CREATE PROCEDURE PrenotazioniTotaliVolontario(IN EmailV VARCHAR(50))
BEGIN
    SELECT PRENOTAZIONELIBRO.Codice AS CodicePrenotazioneLibro, DataConsegna, CodiceCartaceo, EmailUtilizzatore, Tipo, Note
    FROM PRENOTAZIONELIBRO, EVENTOCONSEGNA
    WHERE EmailV=EmailVolontario AND PRENOTAZIONELIBRO.Codice=EVENTOCONSEGNA.CodicePrenotazioneLibro;
END $

#ok
###########################################################################################################################

#leggi segnalazioni ricevute
DELIMITER $
CREATE PROCEDURE SegnalazioniRicevute(IN EmailU VARCHAR(50))
BEGIN
	SELECT * FROM SEGNALAZIONE WHERE EmailUtilizzatore = EmailU;
END $

#ok
###########################################################################################################################

#leggi messaggio ricevuto
DELIMITER $
CREATE PROCEDURE MessaggiRicevuti(IN EmailU VARCHAR(50))
BEGIN
	SELECT * FROM MESSAGGIO WHERE EmailUtilizzatore = EmailU;
END $

#ok
###########################################################################################################################

#cambia giorno di consegna utilizzatore
DELIMITER $
CREATE PROCEDURE CambiaConsegnaUtilizzatore(IN EmailU VARCHAR(50), IN C INT, IN D DATE)
BEGIN
	DECLARE T VARCHAR(50);
    SET T = (SELECT EmailUtilizzatore FROM EVENTOCONSEGNA JOIN PRENOTAZIONELIBRO ON EVENTOCONSEGNA.CodicePrenotazioneLibro=PRENOTAZIONELIBRO.Codice WHERE EVENTOCONSEGNA.Codice=C);
	IF (T=EmailU AND D>=NOW()) THEN
	UPDATE EVENTOCONSEGNA SET DataConsegna=D WHERE Codice=C;
    END IF;
END $

#ok
###########################################################################################################################

#elimina prenotazione posto
DELIMITER $
CREATE PROCEDURE EliminaPrenotazionePosto(IN EmailU VARCHAR(50), IN B VARCHAR(50), IN D DATE)
BEGIN
		DELETE FROM PRENOTAZIONEPOSTO WHERE NomeBibliotecaPostoLettura=B AND EmailUtilizzatore=EmailU AND DataPrenotazione=D;
END $

#ok
###########################################################################################################################

#elimina prenotazione libro
DELIMITER $
CREATE PROCEDURE EliminaPrenotazioneLibro(IN EmailU VARCHAR(50), IN C INT)
BEGIN
	DECLARE T VARCHAR(50);
    DECLARE G INT;
    SET T = (SELECT EmailUtilizzatore FROM PRENOTAZIONELIBRO WHERE Codice=C);
    SET G = (SELECT CARTACEO.Codice FROM CARTACEO JOIN PRENOTAZIONELIBRO ON CARTACEO.Codice=PRENOTAZIONELIBRO.CodiceCartaceo WHERE PRENOTAZIONELIBRO.Codice=C);
    IF (T=EmailU) THEN
		DELETE FROM EVENTOCONSEGNA WHERE CodicePrenotazioneLibro=C;
		DELETE FROM PRENOTAZIONELIBRO WHERE Codice=C;
        UPDATE CARTACEO SET StatoPrestito='Disponibile' WHERE Codice=G;
	END IF;
END $

#ok
###########################################################################################################################

#lista di tutti gli ebook
DELIMITER //
CREATE Procedure EbookDisponibili()
BEGIN
	SELECT Codice, Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, PDF, NrAccessi, Dimensione from EBOOK;
END //

#ok
###########################################################################################################################

#tutti i libri di una biblioteca
DELIMITER //
CREATE Procedure LibriBiblioteca(IN Biblio VARCHAR(100))
BEGIN
	SELECT Codice, Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale FROM CARTACEO
		WHERE NomeBiblioteca=Biblio;
END //

#ok
###########################################################################################################################

#cerca ebook dal nome
DELIMITER $
CREATE PROCEDURE EbookDalNome(IN Title VARCHAR(100))
BEGIN
	SELECT Codice, Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, PDF, NrAccessi, Dimensione FROM EBOOK WHERE Titolo=Title;
END $

#ok
###########################################################################################################################

#cerca libro dal nome
DELIMITER $
CREATE PROCEDURE LibroDalNome(IN Title VARCHAR(100))
BEGIN
	SELECT Codice, Titolo, ListaAutori, Genere, NomeEdizione, AnnoPubblicazione, StatoConservazione, StatoPrestito, NumeroPagine, NumeroScaffale, NomeBiblioteca FROM CARTACEO WHERE Titolo=Title;
END $

#ok
###########################################################################################################################

#tutte le prenotazioni affidamento che il volontario può consegnare
DELIMITER $
CREATE PROCEDURE ConsegneAffidamentoDisponibili()
BEGIN
	SELECT *
    FROM PRENOTAZIONELIBRO
    WHERE (DataFine>=CURDATE()) AND Codice NOT IN
        (SELECT CodicePrenotazioneLibro FROM EVENTOCONSEGNA WHERE DataConsegna>=CURDATE());
END $

#ok
###########################################################################################################################

#tutte le prenotazioni restituzione che il volontario può consegnare
DELIMITER $
CREATE PROCEDURE ConsegneRestituzioneDisponibili()
BEGIN
    SELECT *
    FROM PRENOTAZIONELIBRO
    WHERE (DataFine>=CURDATE()) AND Codice IN
        (SELECT CodicePrenotazioneLibro FROM EVENTOCONSEGNA WHERE DataConsegna>=CURDATE() AND CodicePrenotazioneLibro NOT IN
        (SELECT CodicePrenotazioneLibro FROM EVENTOCONSEGNA WHERE Tipo='Restituzione'));
END $

#ok
###########################################################################################################################
#tutte i libri del sistema
DELIMITER $
CREATE PROCEDURE TuttiILibri()
BEGIN
	SELECT *
    FROM CARTACEO;
END $

#ok
###########################################################################################################################


DELIMITER $
CREATE PROCEDURE NuovoEvento(IN CodPren INT, IN EmailV VARCHAR(50), IN DataC DATE, IN Nota VARCHAR(200))
BEGIN
    DECLARE AFF INT;
    SET AFF = (SELECT Codice FROM PRENOTAZIONELIBRO WHERE (DataFine>=CURDATE()) AND Codice=CodPren AND Codice IN
        (SELECT CodicePrenotazioneLibro FROM EVENTOCONSEGNA WHERE DataConsegna>=CURDATE()));

    IF(DataC >= CURDATE() AND AFF IS NULL) THEN
    INSERT INTO EVENTOCONSEGNA(CodicePrenotazioneLibro, EmailVolontario, DataConsegna, Tipo, Note) VALUES (
            CodPren, EmailV, DataC, 'Affidamento', Nota);
    ELSE
        INSERT INTO EVENTOCONSEGNA(CodicePrenotazioneLibro, EmailVolontario, DataConsegna, Tipo, Note) VALUES (
            CodPren, EmailV, DataC, 'Restituzione', Nota);
        END IF;
END $

###########################################################################################################################

###########################################################################################################################

###########################################################################################################################
