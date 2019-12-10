create or replace function modif_v_ejemplares() returns trigger as $$
begin
    if tg_op = 'INSERT' then
        insert into ejemplares (codigo, libro_id) values (new.codigo, new.libro);
        if not found then return null; end if;
        
    elsif tg_op = 'DELETE' then
        delete from ejemplares where id = old. id;
        if not found then return null; end if;
        return old
        
    elsif tg_op = 'UPDATE' then
        update ejemplares
            set codigo   = new.codigo,
                libro_id = new.libro_id
            where id = old.id;
        if old.id is distinct from new.id then return null; end if;
        update libros
            set titulo   = new.titulo,
                editorial_id = new.editorial_id
            where id = old.libro_id;
    end if;
end;
$$ language plpgsql;

drop trigger if exists modif_v_ejemplares;

create trigger modif_v_ejemplares
instead of insert or update or delete on v_ejemplares
for each row
execute procedure modif_v_ejemplares();
