------------
-- Ventas --
------------
-- INSERTAR SIEMPRE ESPACIOS
drop table if exists cruz.fabricantes cascade;

create table cruz.fabricantes(
    cod_fabricante numeric(3) constraint pk_fabricantes primary key,
    nombre         varchar(15),
    pais           varchar(15)
);

drop table if exists cruz.articulos cascade;

create table cruz.articulos(
    articulo        varchar(20),
    cod_fabricante  numeric(3) constraint fk_articulos_fabricantes references cruz.fabricantes (cod_fabricante)
                               on delete no action on update cascade,
    peso            numeric(3),
    categoria       varchar(10),
    precio_venta    numeric(4),
    precio_costo    numeric(4),
    existencias     numeric(5),
    constraint pk_articulos primary key (articulo, cod_fabricante, peso, categoria),
);
