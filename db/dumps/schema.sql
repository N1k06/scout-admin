-- ricrea da zero tutto il db a prescindere
USE root_db;
DROP DATABASE root_db;
CREATE DATABASE root_db;
USE root_db;

-- Tabella Account
CREATE TABLE Account (
    username VARCHAR(50) PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_persona INT NOT NULL
);

-- Tabella Persona
CREATE TABLE Persona (
    id_persona INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    data_nascita DATE NOT NULL,
    luogo_nascita VARCHAR(50) NOT NULL,
    citta_residenza VARCHAR(50) NOT NULL,
    via_residenza VARCHAR(50) NOT NULL,
    cap_residenza VARCHAR(6) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    id_tutore1 INT DEFAULT NULL,
    id_tutore2 INT DEFAULT NULL
);

-- Tabella Attività
CREATE TABLE Attivita (
    id_attivita INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descrizione TEXT,
    luogo_partenza VARCHAR(100) NOT NULL,
    luogo_arrivo VARCHAR(100) NOT NULL,
    data DATE NOT NULL,
    id_persona INT NOT NULL
);

-- Tabella Pagamento
CREATE TABLE Pagamento (
    id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
    importo DECIMAL(5, 2) NOT NULL,
    metodo VARCHAR(255) NOT NULL,
    data DATE NOT NULL
);

-- Tabella Tipologia
CREATE TABLE Tipologia (
    id_tipologia INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descrizione TEXT NOT NULL
);

-- Tabella Unità
CREATE TABLE Unita (
    id_unita INT AUTO_INCREMENT PRIMARY KEY,
    nome_unita VARCHAR(200),
    id_branca int NOT NULL
);

-- Tabella Branca
CREATE TABLE Branca (
    id_branca INT AUTO_INCREMENT PRIMARY KEY,
    nome_branca VARCHAR(50) NOT NULL,
    min_eta INT NOT NULL,
    max_eta INT NOT NULL
);

-- Tabella Iter
CREATE TABLE Iter (
    id_iter INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descrizione TEXT,
    id_branca int NOT NULL
);

-- tabelle relazioni

-- Tabella Iscrizione
CREATE TABLE Iscrizione (
    anno_associativo INT NOT NULL,
    approvazione_capo BOOLEAN NOT NULL,
    id_persona INT NOT NULL,
    id_pagamento INT NOT NULL,
    id_unita INT NOT NULL,
    id_iter INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_pagamento) REFERENCES Pagamento(id_pagamento) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_unita) REFERENCES Unita(id_unita) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_iter) REFERENCES Iter(id_iter) ON DELETE RESTRICT ON UPDATE CASCADE,
    PRIMARY KEY (anno_associativo, id_persona)
);

-- Tabella Servizio
CREATE TABLE Servizio (
    descrizione TEXT NOT NULL,
    anno_associativo INT NOT NULL,
    id_persona INT NOT NULL,
    id_tipologia INT NOT NULL,
    id_unita INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id_persona) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_tipologia) REFERENCES Tipologia(id_tipologia) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_unita) REFERENCES Unita(id_unita) ON DELETE RESTRICT ON UPDATE CASCADE,
    PRIMARY KEY (anno_associativo, id_persona)
);

-- Tabella Iscrizione
CREATE TABLE Partecipa (
    id_attivita INT NOT NULL,
    id_unita INT NOT NULL,
    FOREIGN KEY (id_attivita) REFERENCES Attivita(id_attivita) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_unita) REFERENCES Unita(id_unita) ON DELETE RESTRICT ON UPDATE CASCADE,
    PRIMARY KEY (id_attivita, id_unita)
);

ALTER TABLE Account
ADD FOREIGN KEY (id_persona) REFERENCES Persona(id_persona);

ALTER TABLE Persona
ADD FOREIGN KEY (id_tutore1) REFERENCES Persona(id_persona),
ADD FOREIGN KEY (id_tutore2) REFERENCES Persona(id_persona);

ALTER TABLE Attivita
ADD FOREIGN KEY (id_persona) REFERENCES Persona(id_persona);

ALTER TABLE Unita
ADD FOREIGN KEY (id_branca) REFERENCES Branca(id_branca);

ALTER TABLE Iter
ADD FOREIGN KEY (id_branca) REFERENCES Branca(id_branca);
