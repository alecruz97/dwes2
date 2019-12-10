drop table if exists cruz.clientes cascade;

create table cruz.clientes(
    nif     varchar(9)  constraint pk_clientes primary key,
    nombre  varchar(255)
);

insert into clientes (nif, nombre)
    values ('11111111A', 'Pepe'),
           ('22222222B', 'María');
           
drop table if exists cruz.articulos cascade;

create table cruz.articulos(
    codigo          numeric(5)      constraint pk_articulos primary key,
    denominacion    varchar(255),
    precio          numeric(6,2)
);

insert into cruz.articulos(codigo, denominacion, precio)
    values (1, 'Martillo', 20),
           (2, 'Alicates', 5),
           (3, 'Manguera', 8.50);
           
drop table if exists cruz.facturas cascade;

create table cruz.facturas(
    numero  numeric(10)     constraint pk_facturas primary key,
    nif     varchar(9)      not null constraint fk_facturas_clientes references cruz.clientes (nif)
                            on delete no action on update cascade,
    fecha   date            not null default current_date
);

insert into cruz.facturas(numero, nif, fecha)
    values (1, '22222222B', current_date - 4),
           (2, '11111111A', default),
           (3, '22222222B', current_date - '1 month'::interval);
           
drop table if exists cruz.lineas cascade;

create table cruz.lineas(
    numero      numeric(10)     constraint fk_lineas_facturas references cruz.facturas (numero)
                                on delete cascade on update cascade,
    codigo      numeric(5)      constraint fk_lineas_articulos references cruz.articulos (codigo)
                                on delete no action on update cascade,
    cantidad    int,
                                constraint pk_lineas primary key (numero, codigo)
);

insert into lineas (numero, codigo, cantidad)
    values (1, 1, 2),
           (1, 3, 4),
           (2, 2, 8),
           (3, 1, 20);
