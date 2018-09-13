
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
    
create or replace function f3() returns trigger as $$

    begin 
        if((select count(*) from Ekspozycja where id_objazd = new.id) != 1)
        then
            raise exception 'Objazd nie może zostać ogłoszony, gdyż nie ma go w ekspozycjach. Dodaj odpowiednią ekspozycję, aby ogłosić objazd';
        end if;
        return new;
    end;
$$ language plpgsql;

drop trigger if exists t3 on Objazd;
create trigger t3 before insert or update
    on objazd for each row
    execute procedure f3();
        
        
        
        
        
