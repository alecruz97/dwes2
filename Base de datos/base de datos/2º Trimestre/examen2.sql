drop table if exists lugares cascade;

create table lugares(
	id              bigserial       constraint pk_lugares primary key,
	denominacion    varchar(255)    not null,
	tipo            char            not null default 'A' constraint ck_tipo_lugar_valido check(tipo in ('A', 'D'))
);

insert into lugares (denominacion, tipo)
values ('P6', 'A'),
       ('Inglés', 'D');

drop table if exists ordenadores cascade;

create table ordenadores(
    id              bigserial       constraint pk_ordenadores primary key,
    marca           varchar(255)    not null,
    modelo          varchar(255),
    lugar_id        bigint          not null constraint fk_ordenadores_lugares references lugares(id) 
                                    on delete no action on update cascade
);

insert into ordenadores (marca, modelo, lugar_id)
values ('Sony', 'Vaio', 1),
       ('Sinclair', 'ZX Spectrum', 2),
       ('HP', '9000', 1);
       
drop table if exists tipo_componentes cascade;

create table tipo_componentes(
    id              bigserial       constraint pk_tipo_componentes primary key,
    tipo            varchar(255)    not null
);

insert into tipo_componentes (tipo)
    values ('Monitor'),
           ('Teclado'),
           ('Disco duro'),
           ('Tarjeta gráfica');
       
drop table if exists componentes cascade;

create table componentes(
    id              bigserial constraint pk_componentes primary key,
    marca           varchar(255)     not null,
    modelo          varchar(255),
    tipo            bigint           not null constraint fk_componentes_tipos_componentes references tipo_componentes (id) 
                                     on delete no action on update cascade,
    ordenador_id    bigint           constraint fk_componentes_ordenadores references ordenadores (id) 
                                     on delete set null on update cascade,
    lugar_id        bigint           constraint fk_componentes_lugares references lugares (id) 
                                     on delete no action on update cascade,
    constraint ck_uno_u_otro check ((ordenador_id is null and lugar_id is not null) or (ordenador_id is not null and lugar_id is null))
);

insert into componentes (marca, modelo, tipo, ordenador_id, lugar_id)
    values ('nVIDIA', 'Cochina', 4, 1, null),
           ('Logitech', 'K260', 2, null, 1),
           ('Seagate', 'Barracuda 1TB', 3, 1, null),
           ('Hitachi', '2TB', 3, 1, null),
           ('Seagate', '500GB', 3, 3, null);
           
drop table if exists ssoo cascade;

create table ssoo(
    id             bigserial           constraint pk_ssoo primary key,
    marca          varchar(255)        not null,
    modelo         varchar(255)
);

insert into ssoo(marca, modelo)
    values ('Microsoft', 'Windows 7'),
           ('Microsoft', 'Windows 10'),
           ('Ubuntu', '16.04'),
           ('Microsoft', 'DOS');
           
drop table if exists instalaciones cascade;

create table instalaciones(
    ordenador_id    bigint              constraint fk_instalaciones_ordenadores references ordenadores (id) 
                                        on delete cascade on update cascade,
    so_id           bigint              constraint fk_instalaciones_ssoo references ssoo (id) 
                                        on delete cascade on update cascade,
    constraint pk_instalaciones primary key (ordenador_id, so_id)
);

insert into instalaciones(ordenador_id, so_id)
    values (1,1),
           (1,2),
           (3,3);
         
--4

update instalaciones
set so_id = (select id from ssoo where modelo = 'Windows 10')
where so_id = (select id from ssoo where modelo = 'Windows 7')
 and ordenador_id in (select id 
                       from ordenadores 
                       where lugar_id in (select id 
                                            from lugares 
                                            where denominacion in ('P6', 'P10')));
                                            
--5

delete from ordenadores
where id in (select o.id
              from ordenadores o join componentes c on c.ordenador_id = o.id
              where tipo = (select id from tipo_componentes where tipo ilike '%Disco duro%')
              group by o.id
              having count(*) = 2);
--6

insert into instalaciones (ordenador_id, so_id)
    select o.id, s.id
     from ordenadores o, ssoo s
     where o.id not in (select ordenador_id from instalaciones) 
           and s.marca = 'Ubuntu' and s.modelo = '16.04';

