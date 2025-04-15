-- Tabella Persona
CREATE TABLE Persona (
    id_persona INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    data_nascita DATE NOT NULL,
    luogo_nascita VARCHAR(50),
    citta_residenza VARCHAR(50),
    cap_residenza VARCHAR(10),
    telefono VARCHAR(15),
    id_tutore1 INT DEFAULT NULL,
    id_tutore2 INT DEFAULT NULL,
    FOREIGN KEY (id_tutore1) REFERENCES Persona(id_persona) ON DELETE SET NULL,
    FOREIGN KEY (id_tutore2) REFERENCES Persona(id_persona) ON DELETE SET NULL,
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
    metodo VARCHAR(255)
);

-- Tabella Branca
CREATE TABLE Branca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    min_eta INT NOT NULL,
    max_eta INT NOT NULL
);

-- Relazione tra Unità e Branca
ALTER TABLE Unita
ADD COLUMN id_branca INT NOT NULL,
ADD FOREIGN KEY (id_branca) REFERENCES Branca(id);

-- Tabella Attività
CREATE TABLE Attivita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descrizione TEXT,
    luogo_partenza VARCHAR(100),
    luogo_arrivo VARCHAR(100),
    data DATE NOT NULL
);

-- Tabella Iter
CREATE TABLE Iter (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione TEXT,
    id_attivita INT NOT NULL,
    FOREIGN KEY (id_attivita) REFERENCES Attivita(id)
);

-- Tabella Servizio
CREATE TABLE Servizio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione TEXT NOT NULL,
    anno_associativo INT NOT NULL
);

-- Tabella Iscrizione
CREATE TABLE Iscrizione (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anno_associativo INT NOT NULL,
    approvazione_capo BOOLEAN NOT NULL,
    via_residenza VARCHAR(100),
    cap_residenza VARCHAR(10),
    id_persona INT NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES Persona(id)
);

-- Tabella Pagamento
CREATE TABLE Pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    importo DECIMAL(10, 2) NOT NULL,
    data DATE NOT NULL,
    id_iscrizione INT NOT NULL,
    FOREIGN KEY (id_iscrizione) REFERENCES Iscrizione(id)
);

-- Tabella Tipologia
CREATE TABLE Tipologia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrizione TEXT NOT NULL
);

-- Relazione tra Tipologia e Servizio
ALTER TABLE Servizio
ADD COLUMN id_tipologia INT NOT NULL,
ADD FOREIGN KEY (id_tipologia) REFERENCES Tipologia(id);