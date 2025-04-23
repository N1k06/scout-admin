-- Tabella Persona
CREATE TABLE Persona (
    id INT AUTO_INCREMENT PRIMARY KEY, --id no id_persona
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    data_nascita DATE NOT NULL,
    luogo_nascita VARCHAR(50) NOT NULL, --non può essere nullo
    via_residenza VARCHAR(50) NOT NULL, --manca via_residenza
    citta_residenza VARCHAR(50) NOT NULL, --manca not null
    cap_residenza VARCHAR(5), --cap_residenza può essere nullo perchè c'è gia la città di residenza/ le cifre del cap in italia sono 5
    telefono VARCHAR(15) NOT NULL, --non può essere nullo(come contatto la persona in caso di emergenza)
    id_tutore1 INT DEFAULT NULL,
    id_tutore2 INT DEFAULT NULL,
    FOREIGN KEY (id_tutore1) REFERENCES Persona(id) ON DELETE SET NULL, --id non id_persona
    FOREIGN KEY (id_tutore2) REFERENCES Persona(id) ON DELETE SET NULL, --id non id_persona
    CHECK (id_tutore1 <> id_tutore2 OR id_tutore1 IS NULL OR id_tutore2 IS NULL) -- Verifica che i due tutori siano diversi
);

-- Tabella Account
CREATE TABLE Account (
    username VARCHAR(50) PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    id_persona INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id)
);

-- Tabella Unità
CREATE TABLE Unita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    id_branca INT NOT NULL,
    FOREIGN KEY (id_branca) REFERENCES Branca(id)
);

-- Tabella Branca
CREATE TABLE Branca (
    nome VARCHAR(50) PRIMARY KEY ,
    min_eta INT NOT NULL,
    max_eta INT NOT NULL
);

--tolgo la alter table tra unita e branca perchè le specifiche sono gia presenti nelle tabella di prima

-- Tabella Attività
CREATE TABLE Attivita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    --nome VARCHAR(50) NOT NULL, --nome non è presente sullo schema er
    descrizione TEXT,
    luogo_partenza VARCHAR(100),
    luogo_arrivo VARCHAR(100),
    data DATE NOT NULL,
    id_persona INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id) --manca la foreing key che collega a persona
);
--Tabella Partecipa --manca tabella partecipa che unisce persona e attività
CREATE TABLE Partecipa (
    id_persona INT NOT NULL,
    id_attivita INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id),
    FOREIGN KEY (id_attivita) REFERENCES Attivita(id),
    PRIMARY KEY (id_persona, id_attivita)
);

-- Tabella Iter
CREATE TABLE Iter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL, --manca nome 
    descrizione TEXT,
    nome_branca VARCHAR(50) NOT NULL, --collegamento errato con attivita (Collegamento con Branca)
    FOREIGN KEY (nome_branca) REFERENCES Branca(nome)
);

-- Tabella Servizio manca il collegamento con tipologia,unita e persona
CREATE TABLE Servizio (
    id_tipologia INT NOT NULL,
    id_persona INT NOT NULL,
    id_unita INT NOT NULL,
    anno_associativo YEAR NOT NULL,
    FOREIGN KEY (id_tipologia) REFERENCES Tipologia(id),
    FOREIGN KEY (id_persona) REFERENCES Persona(id),
    FOREIGN KEY (id_unita) REFERENCES Unita(id),
    PRIMARY KEY (id_persona, id_unita, anno_associativo) --aggiunto anno_associativo per primary key deve essere univoco per ogni tupla

);

-- Tabella Iscrizione --manca collegamenti 
CREATE TABLE Iscrizione (
    anno_associativo INT NOT NULL,
    approvazione_capo BOOLEAN NOT NULL,
    id_persona INT NOT NULL,
    id_iter INT NOT NULL,
    id_unita INT NOT NULL,
    id_pagamento INT NOT NULL,
    id_persona INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id),
    FOREIGN KEY (id_unita) REFERENCES Unita(id),
    FOREIGN KEY (id_iter) REFERENCES Iter(id),
    FOREIGN KEY (id_pagamento) REFERENCES Pagamento(id),
    PRIMARY KEY (anno_associativo, id_persona, id_unita)--aggiunto anno_associativo per primary key deve essere univoco per ogni tupla
);

-- Tabella Pagamento
CREATE TABLE Pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    importo DECIMAL(10, 2) NOT NULL,
    metodo VARCHAR(50) NOT NULL, --assenza del campo metodo
    --data non è presente sullo schema er --La references è gia prensente su iscrizione di pagamento
);

-- Tabella Tipologia
CREATE TABLE Tipologia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione TEXT NOT NULL
);

--tolgo la alter table tra servizio e tipologia perchè le specifiche sono gia presenti nelle tabella di prima