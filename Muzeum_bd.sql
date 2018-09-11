
drop table if exists Artysta cascade;
drop table if exists Eksponat cascade;
drop table if exists Ekspozycja cascade;
drop table if exists Galerie cascade;
drop table if exists Objazd cascade;
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

-- Table: Eksponat
CREATE TABLE Eksponat (
    id serial  PRIMARY KEY,
    tytuł varchar(40)  NOT NULL,
    typ varchar(15)  NOT NULL,
    wysokosc int  NOT NULL,
    szerokosc int  NOT NULL,
    waga int  NOT NULL,
    id_twórca int  REFERENCES Artysta,
    CONSTRAINT 	sprawdzWymiary check (wysokosc > 0 and szerokosc > 0 and waga > 0)
);

-- Table: Ekspozycja
CREATE TABLE Ekspozycja (
    id serial PRIMARY KEY,
    id_eksponat int  NOT NULL REFERENCES Eksponat,
    nr_sala int REFERENCES Sala,
    id_objazd int REFERENCES Objazd,
    poczatek date  NOT NULL,
    koniec date  NOT NULL,
    CONSTRAINT sprawdzDaty (poczatek <= koniec),
    CONSTRAINT sprawdzMiesce ((nr_sala is NULL and id_objazd is not NULL) or (nr_sala is not NULL))
);

-- Table: Galerie
CREATE TABLE Galerie (
    id serial PRIMARY KEY,
    nazwa varchar(30)  NOT NULL,
);

-- Table: Objazd
CREATE TABLE Objazd (
    id serial  	PRIMARY KEY,
    miasto varchar  NOT NULL,
);

-- Table: Sale
CREATE TABLE Sale (
    nr serial  PRIMARY KEY,
    id_galeria int  NOT NULL REFERENCES Galeria,
    pojemność int  NOT NULL,
);


-- End of file.

