insert into Artysta (id, imie, nazwisko, rokNarodzin, rokSmierci) values(1, 'Salvador', 'Dali', 1904, 1989);
insert into Artysta (id, imie, nazwisko, rokNarodzin, rokSmierci) values(2, 'Rembrandt', 'van Rijn', 1606, 1669);
insert into Artysta (id, imie, nazwisko, rokNarodzin, rokSmierci) values(3, 'Vincent', 'van Gogh', 1853, 1890);
insert into Artysta (id, imie, nazwisko, rokNarodzin, rokSmierci) values(4, 'Pablo', 'Picasso', 1881, 1973);
insert into Artysta (id, imie, nazwisko, rokNarodzin, rokSmierci) values(5, 'Claude', 'Monet', 1840, 1926);

insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(1, 'Profil czasu', 'rzezba', 400, 130, 1300, 1);
insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(2, 'Trwałość pamięci', 'obraz', 24, 33, 1, 1);
insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(3, 'Płonąca żyrafa', 'obraz', 35, 27, 1, 1);
insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(4, 'Lekcja anatomii doktora Tulpa', 'obraz', 170, 217, 1, 2);
insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(5, 'Gwiaździsta noc', 'obraz', 74, 92, 1, 3);
insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(6, 'Autoportret', 'obraz', 65, 54, 1, 3);
insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(7, 'Guernica', 'obraz', 349, 776, 3, 4);
insert into Dzielo (id, tytul, typ, wysokosc, szerokosc, waga, id_tworca) values(8, 'Kobieta z parasolem', 'obraz', 100, 82, 1, 5);

insert into Galerie(id, nazwa) values(1, 'Malarstwo impresjonistyczne');
insert into Galerie(id, nazwa) values(2, 'Malarstwo hiszpańskie');

insert into Sale(nr, id_galeria, pojemnosc) values (1, 1, 2);
insert into Sale(nr, id_galeria, pojemnosc) values (2, 1, 5);
insert into Sale(nr, id_galeria, pojemnosc) values (3, 2, 2);
insert into Sale(nr, id_galeria, pojemnosc) values (4, 2, 1);

insert into Objazd(id, miasto) values(1, 'Wąchock');

insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(1, 2, 3, NULL, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(2, 3, 3, NULL, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(3, 7, 4, NULL, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(4, 1, NULL, 1, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(5, 8, 2, NULL, '2018-01-15', '2018-10-15');
