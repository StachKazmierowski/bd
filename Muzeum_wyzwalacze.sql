
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
        licznik integer := 0;
        pojemnosc integer;
        
    begin
        
        if (new.id_objazd is not null)
        then
            return new;
        end if;
        
        
        
        
        
        
        
