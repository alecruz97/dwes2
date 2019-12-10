drop table if exists cruz.libros cascade;

create table cruz.libros(
    id              bigint          constraint pk_libros primary key,
    isbn            varchar(13)     not null constraint uq_libros_isbn unique,
    titulo          varchar(255),
    autor           varchar(255)
);

insert into libros (id, titulo, autor, isbn)
    values (1, 'Base de datos para principiantes', 'Néstor Tilla', '123456789012X'),
           (2, 'Programación para aficionados', 'Felipe Lotas', '9998887776544'),
           (3, 'Entrenamiento de gatos', 'Manolo Miau', '11223344556');

drop table if exists cruz.lectores cascade;

create table cruz.lectores(
    id              bigint          constraint pk_lectores primary key,
    numero          numeric(8)      not null constraint uq_lectores_numero unique,
    nombre          varchar(255),
    telefono        numeric(9)
);

insert into lectores (id, numero, nombre, telefono)
    values (1, 1, 'Pepe', null),
           (2, 2, 'María', null);

drop table if exists cruz.prestamos cascade;

create table cruz.prestamos(
    id              bigint          constraint pk_prestamos primary key,
    libro_id        bigint          not null constraint fk_prestamos_libros references cruz.libros (id)
                                    on delete no action on update cascade,
    lector_id       bigint          not null constraint fk_prestamos_lectores references cruz.lectores (id)
                                    on delete no action on update cascade,
    creacion        timestamptz     not null default current_timestamp,
    devolucion      timestamptz,
                                    constraint uq_prestamos_libro_id_lector_id_creacion unique (libro_id, lector_id, creacion)
);

insert into prestamos (id, libro_id, lector_id, creacion, devolucion)
    values (1, 1, 2, current_timestamp - '4 days'::interval, null),
           (2, 2, 2, current_timestamp - '2 days'::interval, current_timestamp - '1 days'::interval),
           (3, 2, 1, default, null);
           
create view v_prestamos as
    select p.*, age(coalesce(p.devolucion, current_timestamp), p.creacion) as duracion, 
           age(coalesce(p.devolucion, current_timestamp), p.creacion) > '15 days':: interval as atrasado,
           l.isbn, l.titulo, l.autor, le.numero, le.nombre, le.telefono 
    from prestamos p join libros l on p.libro_id = l.id join lectores le on p.lector_id = le.id;
    
create view v_prestamos_atrasados as
    select *
    from v_prestamos
    where atrasado;
    
create view v_libros as
    with t as (
        select libro_id
        from prestamos
        where devolucion is null)
   
        select *, true as prestado
        from libros
        where id in (select libro_id
                     from t)
        union
        select *, false as prestado
        from libros
        where id not in (select libro_id
                         from t);
                         
create view v_prestamos_atrasados_pendientes as
    select *
    from v_prestamos_atrasados
    where devolucion is null;
    
create view v_lectores as
    select *, true as moroso
    from lectores
    where id in (select lector_id from v_prestamos_atrasados_pendientes)
    union
    select *, false as moroso
    from lectores
    where id not in (select lector_id from v_prestamos_atrasados_pendientes);
