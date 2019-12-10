create or replace function aa() returns trigger as $$
begin
    raise notice '(aa) id = %', new.id;
    return null;
end;
$$ language plpgpsql;

drop trigger if exists aa on socios;

create trigger aa
after insert on socios
for each row
execute procedure aa();


create or replace function zz() returns trigger as $$
begin
    raise notice '(zz) id = %', new.id;
    return new;
end;
$$ language plpgpsql;

drop trigger if exists zz on socios;

create trigger zz
after insert on socios
for each row
execute procedure zz();
