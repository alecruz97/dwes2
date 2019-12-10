create or replace function prestamos_maximos() returns trigger as $$
declare
    v_cuantos numeric;
begin
    if tg_op = 'UPDATE' then
        select count(*)
            into v_cuantos
        from (select *
                from prestamos
                except
                select old.*
                union
                select new.*) p
        where socio_id = new.socio_id and devolucion is null;
    
    elsif tg_op = 'INSERT' then
        select count(*)
            into v_cuantos
        from (select *
                from prestamos
                union
                select new.*) p
        where socio_id = new.socio_id and devolucion is null;
    end if;
    
    if v_cuantos > 3 then
        raise exception 'El socio % ya tiene tres prestamos pendientes.'. new.socio_id;
    end if;
    return new;
        


    //*if tg_op = 'INSERT' then
        select count(*)
            into v_cuantos
        from prestamos
        where socio_id = new.socio_id and devolucion is null;
        
        if v_cuantos >= 3 and new.devolucion is null then
            raise exception 'El socio % ya tiene tres libros prestados.', new.socio_id;
        end if;
        
        return new;
        
    elsif tg_op = 'UPDATE' then
        select count(*)
            into v_cuantos
        from prestamos
        where socio_id = new.socio_id and devolucion is null;
        
        if old.socio_id != new.socio_id and devolucion is null then
            v_cuantos := v_cuantos +1;
        end if;
        
        if v_cuantos > 3 then
            raise exception 'El socio % ya tiene tres libros prestados', new.socio_id;            
        end if;
    end if;
    */
end;
$$ language plpgsql;

drop trigger if exists prestamos_maximos on prestamos;

create trigger prestamos_maximos
before insert or update of socio_id, devolucion on prestamos
for each row
execute procedure prestamos_maximos();

