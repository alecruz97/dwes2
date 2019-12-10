drop table if exists cruz.alumnos cascade;

create table cruz.alumnos(
	dni	   varchar(9) constraint pk_alumnos primary key,
	nombre	   varchar(255) not null,
	apellidos  varchar(255) not null,
	direccion  text,
	poblacion  varchar(255) default 'Sanlúcar de Barrameda',
	provincia  varchar(255) default 'Cádiz',
	codpostal  numeric(5) default '11540',
	telefono   numeric(30) constraint uq_alumnos_telefono unique
			       constraint ck_alumnos_telefono_positivo check (telefono >= 0),
	constraint uq_alumnos_nombre_apellidos unique (nombre, apellidos)
);

insert into cruz.alumnos(dni, nombre, apellidos, direccion, telefono, poblacion, codpostal)
	values('52525252A', 'Pepe', 'Garcia', 'C/ Falsa, 123', 666666666, 'Chipiona', 11550),
	      ('11111111B', 'María', 'González', 'C/ Nosequé, 25', 111111111, default, default);

drop table if exists cruz.asignaturas cascade;

create table cruz.asignaturas(
	codigo 		varchar(5) constraint pk_asignaturas primary key,
	denominacion 	varchar(255) not null,
	creditos 	numeric(2) constraint ck_asignaturas_creditos_positivos check (creditos is null or creditos >= 0)
);

insert into cruz.asignaturas(codigo, denominacion, creditos)
	values('1234', 'Bases de datos', 85);

drop table if exists cruz.notas cascade;

create table cruz.notas(
	dni	 varchar(9) constraint fk_notas_alumnos references cruz.alumnos (dni) 
			    on delete no action 
			    on update cascade,
	codigo 	 varchar(5) constraint fk_notas_asignaturas references cruz.asignaturas (codigo) 
			    on delete no action 
			    on update cascade,
	nota 	 numeric(3,1) constraint ck_notas_nota_valida check (nota between 1.0 and 10.0),
	constraint pk_notas primary key (dni, codigo)
);

insert into cruz.notas(dni, codigo, nota)
    values ('11111111B', '1234', 5.0);
