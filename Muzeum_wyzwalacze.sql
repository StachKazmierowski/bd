
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
        test integer;
        
    begin
        
        if (new.id_objazd is not null)
        then
            return new;
        end if;
        
        poj := (select pojemnosc from sale where nr = new.nr_sala);
        raise notice 'value: %', poj;
        
        loop
            exit when dzien = (select new.koniec);
            test := (select count(*) from Ekspozycja where (nr_sala = new.nr_sala) and (poczatek <= dzien) and (koniec >= dzien));
            if ((select count(*) from Ekspozycja where (nr_sala = new.nr_sala) and (poczatek <= dzien) and (koniec >= dzien)) >= poj)
            then
                raise exception 'Wybrana sala jest pełna w przynajmniej jednym dniu planowanej ekspozycji';
            end if;
            raise notice 'value: %', test;
            raise notice 'value: %', dzien;
            dzien := (select dzien + interval '1 day');
        end loop;
        return new;
    end;
$$ language plpgsql;

drop trigger if exists t2 on Ekspozycja;
create trigger t2 before insert or update
    on Ekspozycja for each row
    execute procedure f2();
    
--co najmniej jeden eksponat artysty w muzeum    

        

        
        
        
