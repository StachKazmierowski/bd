drop table if exists Ekspozycja cascade;

CREATE TABLE Ekspozycja (
    id serial PRIMARY KEY,
    id_dzielo int  NOT NULL REFERENCES Dzielo,
    nr_sala int REFERENCES Sale,
    id_objazd int REFERENCES Objazd,
    poczatek date  NOT NULL,
    koniec date  NOT NULL,
    CONSTRAINT sprawdzDaty check (poczatek <= koniec),
    CONSTRAINT sprawdzMiesce check ((nr_sala is NULL and id_objazd is not NULL) or (nr_sala is not NULL))
);


--jedno dzieło w jednym miejcu w jednym czasie

create or replace function f1 () returns trigger as $$

  begin
  
    if (exists (select * from Ekspozycja where id != new.id and id_dzielo = new.id_dzielo and (new.poczatek < koniec) or (new.koniec < poczatek)))
    then
        raise exception 'Wskazany termin koliduje z inną ekspozycją tego dzieła.' ;
    else
        return new;
    end if;
  end;
$$ language plpgsql;
        
drop trigger if exists t1 on Ekspozycja;
create trigger t1 before insert or update
    on Ekspozycja for each row
    execute procedure f1();
        
        
-- liczba eksponatów nie przekracza pojemnosci sali
        
create or replace function f2 () returns trigger as $$
    
    declare
        dzien date := new.poczatek;
        licznik integer;
        poj integer;
        
    begin
        
        if (new.id_objazd is not null)
        then
            return new;
        end if;
        
        poj := (select pojemnosc from sale where nr = new.nr_sala);
        
        loop
            exit when dzien = new.koniec;
            if ((select count(*) from Ekspozycja where nr_sala = new.nr_sala) >= poj)
            then
                raise exception 'Wybrana sala jest pełna w przynajmniej jednym dniu planowanej ekspozycji';
            end if;
            dzien := (select dzien + interval '1 day');
        end loop;
        return new;
    end;
$$ language plpgsql;

drop trigger if exists t2 on Ekspozycja;
create trigger t2 before insert or update
    on Ekspozycja for each row
    execute procedure f2();
    
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(1, 2, 3, NULL, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(2, 3, 3, NULL, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(3, 7, 4, NULL, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(4, 1, NULL, 1, '2018-01-15', '2018-10-15');
insert into Ekspozycja(id, id_dzielo, nr_sala, id_objazd, poczatek, koniec) values(5, 8, 2, NULL, '2018-01-15', '2018-10-15');
