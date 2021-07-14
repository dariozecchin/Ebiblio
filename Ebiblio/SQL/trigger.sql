#TRIGGER

 #Utilizzare un trigger per implementare l’operazione cambio di stato di libro cartaceo, da Disponibile a Prenotato
   #nel momento in cui un utente utilizzatore ha inserito una prenotazione per quel libro.

CREATE TRIGGER LibroPrenotato
AFTER INSERT ON PRENOTAZIONELIBRO
FOR EACH ROW
UPDATE CARTACEO SET StatoPrestito = 'Prenotato' WHERE (NEW.CodiceCartaceo=CARTACEO.Codice);

################################


#Utilizzare un trigger per implementare l’operazione cambio di stato di libro cartaceo, da Prenotato a Consegnato
   #nel momento in cui un utente volontario inserisce un evento di consegna di quel libro, di tipo “Affidamento”.

DELIMITER $
CREATE TRIGGER TriggerEventoConsegna
AFTER INSERT ON EVENTOCONSEGNA
FOR EACH ROW BEGIN
	DECLARE C INT;
    SET C = (SELECT DISTINCT PRENOTAZIONELIBRO.CodiceCartaceo FROM PRENOTAZIONELIBRO JOIN EVENTOCONSEGNA ON PRENOTAZIONELIBRO.Codice = EVENTOCONSEGNA.CodicePrenotazioneLibro
		WHERE NEW.CodicePrenotazioneLibro = PRENOTAZIONELIBRO.Codice);
	IF (NEW.Tipo = 'Affidamento') THEN
		UPDATE CARTACEO SET CARTACEO.StatoPrestito = 'Consegnato' WHERE C = CARTACEO.Codice;
	ELSE
		UPDATE CARTACEO SET CARTACEO.StatoPrestito = 'Disponibile' WHERE C = CARTACEO.Codice;
	END IF;
END$

#########################
DELIMITER;


 #tilizzare un trigger per implementare l’operazione di passaggio di stato (da Attivo a Sospeso)
   #di un account di un utente utilizzatore, ogni qualvolta viene inserita la terza segnalazione da parte di un amministratore.


DELIMITER //
CREATE TRIGGER CambioStato AFTER INSERT ON SEGNALAZIONE
FOR EACH ROW
BEGIN
	IF NEW.NrSegnalazione = 3 THEN
		UPDATE UTILIZZATORE SET StatoAccount = 'Sospeso' WHERE Email = NEW.EmailUtilizzatore ;
	END IF ;
  END ; //

DELIMITER ;

 ################

#aggiunge un accesso al NrAccessi di un ebook
DELIMITER $
CREATE TRIGGER LetturaEbook
AFTER INSERT ON LETTURA
FOR EACH ROW
UPDATE EBOOK SET NrAccessi = NrAccessi+1 WHERE (NEW.CodiceEbook=EBOOK.Codice)


################
