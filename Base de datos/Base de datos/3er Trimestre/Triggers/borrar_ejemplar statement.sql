create or replace function borrar_libro returns trigger as $$
begin
    delete from libros
    where id not in (select libros_id from ejemplares);
    
    if found then
        raise notice 'Se han eliminado los libros que han quedado sin ejemplares.';
    end if;
    
    return null;
end;
$$ language plpgsql;

drop trigger if exists borrar_libro on ejemplares;

create trigger borrar_libro
after delete or truncate or update of libro_id on ejemplares
for each statement
execute procedure borrar_libro();

--LOS DISPARADORES QUE SE ACTIVAN POR UN TRUNCATE SOLO SE ACTIVAN EN LOS FOR EACH STATEMENT
