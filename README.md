Requisiti funzionali dell’applicazione web “Scout-Admin”

L’applicazione web Scout-Admin è stata progettata con l’obiettivo principale di facilitare la gestione dei dati anagrafici e delle attività dei membri iscritti a un gruppo scout. L’app intende semplificare e centralizzare la gestione delle informazioni relative agli utenti, alle persone e alle attività del gruppo, attraverso un’interfaccia web intuitiva e un backend strutturato secondo principi RESTful.

Funzionalità principali:
1-Gestione utenti e account:
-Creazione di un account personale per i genitori o per i membri maggiorenni.
-Autenticazione tramite credenziali (login sicuro).
-Possibilità per l’utente di aggiornare e modificare autonomamente i propri dati personali.

2-Gestione delle persone iscritte:
-Inserimento dei dati anagrafici e dei dettagli personali degli iscritti al gruppo scout.
-Visualizzazione completa delle informazioni relative a ciascun iscritto (accessibile solo al personale autorizzato).
-Modifica delle informazioni già presenti nel sistema.

3.Gestione delle attività scout:
-Visualizzazione del calendario e dei dettagli delle attività programmate.
-Associazione di persone specifiche ad attività, unità e branche di appartenenza.
-Tracciamento della partecipazione degli utenti alle varie iniziative scout.


Architettura e organizzazione dell’applicazione


L’app è costruita secondo un’architettura client-server e fa uso di un’API REST per la comunicazione tra frontend e backend.

Frontend (Client):
Realizzato con tecnologie web standard: HTML, CSS e JavaScript.
Utilizza la Fetch API per l’invio e la ricezione di dati in formato JSON verso e dal server.
Il file script.js è responsabile dell’invio dei dati (es. una nuova persona) tramite chiamata HTTP POST e della ricezione dei dati da visualizzare dinamicamente in tabelle HTML.

Backend (Server):
Scritto in PHP e ospitato tramite Firebase Studio con supporto per backend PHP personalizzato.
È presente un file router.php, che agisce come router personalizzato per la gestione delle richieste HTTP in ingresso (GET, POST, PUT), smistandole verso le funzioni appropriate.

Funzioni principali del backend:
-gestisci_elenco_persone(): restituisce l’elenco completo delle persone registrate (metodo GET).
-gestisci_persone_per_id($id): restituisce i dettagli di una persona specifica identificata tramite ID (metodo GET).
-inserimento_persone(): consente di inserire una nuova persona nel database (metodo POST).
-gestisci_login() / gestisci_signup(): gestiscono rispettivamente login e registrazione degli utenti.
-gestisci_attività($id): recupera e restituisce i dettagli di una determinata attività tramite ID.


Database relazionale
Il database utilizzato è MySQL e lo schema è definito all’interno di un file schema.sql.
Le principali tabelle relazionali comprendono: Persona, Account, Attività, e altre eventualmente necessarie per le relazioni (es. partecipazioni, ruoli, unità, branche).Le query vengono eseguite in maniera sicura utilizzando prepared statements (tramite estensioni PDO o mysqli di PHP), in modo da prevenire vulnerabilità comuni come SQL Injection.

Routing e API REST
L’app utilizza un’architettura RESTful per gestire le comunicazioni tra frontend e backend. Le principali rotte sono:
-GET /api/persone: restituisce l’elenco completo delle persone registrate.
-GET /api/persone/{id}: restituisce i dati di una persona specifica.
-POST /api/persone: inserisce una nuova persona nel database.
-PUT /api/persone/{id}: aggiorna i dati di una persona esistente.
Le richieste sono gestite dal file router.php, che smista le chiamate HTTP verso le funzioni PHP appropriate.








