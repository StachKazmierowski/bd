
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
        
        if ((new.id_objazd is not null) or (new.poczatek > new.koniec))
        then
            return new;
        end if;
        
        poj := (select pojemnosc from sale where nr = new.nr_sala);

        
        loop
            exit when dzien = (select new.koniec);
            if ((select count(*) from Ekspozycja where (nr_sala = new.nr_sala) and (poczatek <= dzien) and (koniec >= dzien)) >= poj)
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
    
--co najmniej jeden eksponat artysty w muzeum    

create or replace function f3 () returns trigger as $$
    
    declare
        dzien date := new.poczatek;
        id_artysta integer := (select id_tworca from Dzielo where id = new.id_dzielo);
    
    begin
        
        if ((new.id_objazd is null) or (new.poczatek > new.koniec) or ((select id_tworca from Dzielo where id = new.id_dzielo) is null))
        then
            return new;
        end if;
        
        loop
            exit when dzien = (select new.koniec);
            if ((select count(*) from (Dzielo inner join ekspozycja on dzielo.id = ekspozycja.id_dzielo) where (id_tworca = id_artysta) and (poczatek <= dzien) and (koniec >= dzien) and (id_objazd is null)) < 2)
            then
                raise exception 'To aktualnie ostatni eksponat tego artysty w naszym muzeum.';
            end if;
            dzien := (select dzien + interval '1 day');
                    end loop;
        return new;
    end;
$$ language plpgsql;
       
drop trigger if exists t3 on Ekspozycja;
create trigger t3 before insert or update
    on Ekspozycja for each row
    execute procedure f3();
    
-- nie wiecej niz 30 dni w roku poza muzeum


create or replace function czasObjazdowy (y integer, id_eksponat integer) returns integer as $$

  declare
    czas integer := 0;
    pierwszy date := date (y || '-01-01');
    ostatni date := date (y || '-12-31');
    
  begin
    
    select
      sum(objazd) into czas
    from
      (select as objazd
        from
        (select
            least(dataZakonczenia, lt) - greatest(dataRozpoczecia, gt) + 1 as ob
          from
            Ekspozycja
          where
            id_objazd is not null and id_dzielo = id_eksponat);
            
    raise notice 'Value: %', czas;
    
  end;
$$ language plpgsql;

    
 create or replace function f4 () returns trigger as $$
 
    declare
        dzien date := new.poczatek;
        day_count1 integer := 0;
        day_count2 integer := 0;
        
        begin
       
          create temporary table czas as select id and 
            
        
            if ((new.objazd is null) or (new.poczatek > new.koniec)
            then
                return new;
            end if;
                
            loop
                exit when dzien = new.koniec
         
        
        
