--Crear disparador para añadir un ejemplar al añadir un nuevo libro
create or replace function crear_ejemplar returns trigger as $$
begin
    insert into ejemplares (id, libro_id)
        select coalesce(max(id) + 1), new.id
        from ejemplares;
    if found then
        raise notice 'Se ha creado automáticamente un ejemplar de ese nuevo libro.';
    end if;
    return new;
end;
$$ language plpgsql;

drop trigger if exists crear_ejemplar on libros;

create trigger crear_ejemplar
after insert on libros
for each row
execute procedure crear_ejemplar();
