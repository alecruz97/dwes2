create or replace function borrar_libro returns trigger as $$
begin
    perform *
    from ejemplares
    where libro_id = old.libro_id;
    
    if not found then
        delete from libros 
        where id = old.libro_id;
        raise notice 'Se ha borrado también el libro asociado al no tener más ejemplares.';
    end if;
    
    return old;
end;
$$ language plpgsql;

drop trigger if exists borrar_libro on ejemplares;

create trigger borrar_libro
after delete on ejemplares
for each row
execute procedure borrar_libro();
