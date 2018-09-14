
drop table if exists Artysta cascade;
drop table if exists Dzielo cascade;
drop table if exists Ekspozycja cascade;
drop table if exists Galerie cascade;
drop table if exists Sale cascade;


-- tables
-- Table: Artysta
CREATE TABLE Artysta (
    id serial PRIMARY KEY,
    imie varchar(20)  NOT NULL,
    nazwisko varchar(20)  NOT NULL,
    rokNarodzin int  NOT NULL,
    rokSmierci int,
    CONSTRAINT sprawdzDaty check (rokSmierci is NULL or rokNarodzin <= rokSmierci)
);

-- Table: Galerie
CREATE TABLE Galerie (
    id serial PRIMARY KEY,
    nazwa varchar(30)  NOT NULL
);

-- Table: Sale
CREATE TABLE Sale (
    nr serial  PRIMARY KEY,
    id_galeria int  NOT NULL REFERENCES Galerie,
    pojemnosc int  NOT NULL
);

-- Table: Dzielo
CREATE TABLE Dzielo (
    id serial  PRIMARY KEY,
    tytul varchar(40)  NOT NULL,
    typ varchar(15)  NOT NULL,
    wysokosc int  NOT NULL,
    szerokosc int  NOT NULL,
    waga int  NOT NULL,
    id_tworca int  REFERENCES Artysta,
    CONSTRAINT 	sprawdzWymiary check (wysokosc > 0 and szerokosc > 0 and waga > 0)
);

-- Table: Ekspozycja
CREATE TABLE Ekspozycja (
    id serial PRIMARY KEY,
    id_dzielo int  NOT NULL REFERENCES Dzielo,
    nr_sala int REFERENCES Sale,
    miasto varchar(20),
    poczatek date  NOT NULL,
    koniec date  NOT NULL,
    CONSTRAINT sprawdzDaty check (poczatek <= koniec),
    CONSTRAINT sprawdzMiesce check ((nr_sala is NULL and miasto is not NULL) or (nr_sala is not NULL))
);




-- End of file.

