# Configurazione MariaDB e phpMyAdmin con Docker su NixOS

Dockerfile e docker-compose.yml presi da [qui](https://github.com/br0kenpixel/xampp2docker)
e personalizzati per funzionare "out of the box" su Project IDX (NixOS).

## Obiettivo
Configurare un ambiente di sviluppo cloud per web-app con MariaDB e phpMyAdmin utilizzando Docker, assicurando che:
- Il DB sia accessibile da remoto con PHPMyAdmin.
- L'ambiente funzioni correttamente su NixOS.
- Sia possibile accedere a qualsiasi risorsa presente nel server accedendo alla specifica porta (3000).

Nota: potrebbe essere necessario rendere pubblici i link di accesso nella sezione "Backend Ports".

## Modifiche principali

### 1. **File `dev.nix`**
Il file `dev.nix` è stato configurato per:
- Installare Docker e Docker Compose.
- Abilitare il servizio Docker.
- Eseguire uno script personalizzato all'avvio del workspace per configurare MariaDB.

### 2. **Script `setup-mariadb.sh`**
Questo script:
1. Rimuove e ricrea la directory `mariadb_run` per evitare conflitti con i permessi di MariaDB.
2. Avvia i container definiti in `docker-compose.yml`.
3. Configura MariaDB per accettare connessioni da qualsiasi host (`%`).
4. Configura Apache per servire anche file senza estensione php (utile per alcuni progetti, ad esempio link shortener) trasferendo il file `.htaccess`.

### 3. **File di configurazione `Docker`**
- `docker-compose.yml` è stato adattato per consentire l'avvio di MariaDB ed evitare problemi di permessi su NixOS (cartella `mariadb_run`)
- `Dockefile` è stato modificato per installare il gestore pacchetti di PHP (composer)

## Integrazione con Github
Se il push automatico fallisce, loggarsi manualmente da terminale con `gh auth login`, e successivamente dare `git push` sempre dalla shell.
Può essere d'aiuto resettare l'istanza dopo aver eseguito il login da terminale.
