------------
-- Examen --
------------

drop table if exists cruz.tarifas cascade;

create table cruz.tarifas(
    id        char(1) constraint pk_tarifas primary key,
    tipo      varchar(255),
    importe   numeric(5,2)
);

drop table if exists cruz.socios cascade;

create table cruz.socios(
    id          bigint          constraint pk_socios primary key,
    nombre      varchar(255),
    direccion   varchar(255),
    telefono    numeric(9),
    fecha_alta  date,
    id_tarifa   char(1)         constraint fk_socios_tarifas references cruz.tarifas (id)
                                on delete no action on update cascade
);

drop table if exists cruz.cuotas;

create table cruz.cuotas(
    id_socio   bigint           constraint fk_cuotas_socios references cruz.socios (id)
                                on delete no action on update cascade,
    año        numeric(4),
    mes        numeric(2),
                                constraint pk_cuotas primary key (id_socio, mes, año)
);

drop table if exists cruz.tipos;

create table cruz.tipos(
    id      numeric(10)         constraint pk_tipos primary key,
    denom   varchar(255)
);

drop table if exists cruz.materiales;

create table cruz.materiales(
    id          numeric(10)     constraint pk_materiales primary key,
    denom       varchar(255),
    id_tipo     numeric(10)     constraint fk_materiales_tipo references cruz.tipos (id)
                                on delete no action on update cascade
);
