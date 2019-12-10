-------------------------------
-- Base de datos "Instituto" --
-------------------------------

create table alumnos(
	dni	   varchar(9) constraint pk_alumnos primary key,
	nombre	   varchar(255) not null,
	apellidos  varchar(255) not null,
	direccion  text,
	telefono   numeric(30) constraint uq_alumnos_telefono unique
);
  -- poner alumnos solo como poner cruz.alumnos es lo mismo en la base de datos de clase, siempre y cuando exista un esquema como el usuario
  -- para señalizar si lo quieres crear en el esquema public hay que señalizar "public.(nombre tabla)".

  -- definición de restricciones para columnas codigo de arriba, para tablas codigo de abajo.

create table alumnos(
	dni	   varchar(9) constraint pk_alumnos primary key,
	nombre	   varchar(255) not null,
	apellidos  varchar(255) not null,
	direccion  text,
	telefono   numeric(30),
	constraint uq_alumnos_telefono unique (telefono),
	constraint uq_alumnos_nombre_apellidos unique (nombre, apellidos)
);

--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------
drop table if exists cruz.alumnos;

create table cruz.alumnos(
	dni	   varchar(9) constraint pk_alumnos primary key,
	nombre	   varchar(255) not null,
	apellidos  varchar(255) not null,
	direccion  text,
	telefono   numeric(30) constraint uq_alumnos_telefono unique
			       constraint ck_alumnos_telefono_positivo check (telefono >= 0),
	constraint uq_alumnos_nombre_apellidos unique (nombre, apellidos)
);


--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------


insert into cruz.alumnos(dni, nombre, apellidos, direccion, telefono)
	values('52525252A', 'Pepe', 'Garcia', 'C/ Falsa, 123', 666666666),
	      ('11111111B', 'María', 'González', 'C/ Nosequé, 25', 111111111);

drop table if exists cruz.asignaturas;

create table cruz.asignaturas(
	codigo 		varchar(5) constraint pk_asignaturas primary key,
	denominacion 	varchar(255) not null,
	creditos 	numeric(2) constraint ck_asignaturas_creditos_positivos check (creditos is null or creditos >= 0)
);

insert into cruz.asignaturas(codigo, denominacion, creditos)
	values('1234', 'Bases de datos', 85);


--------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------


drop table if exists cruz.notas;

create table cruz.notas(
	dni 	varchar(9) constraint fk_notas_alumnos references cruz.alumnos (dni) -- definir clave ajena en columna 
			    on delete no action 
			    on update cascade,
		     -- Asignar valor por defecto a una columna con "default"
			-- on delete no action (por defecto opcion mas conservadora)
			-- on delete cascade (borrado en cascada)
			-- on delete set null (pone null en las claves ajenas)	
	codigo  varchar(5) contraint fk_notas_asignaturas,
	nota 	numeric(3,1) constraint ck_notas_nota_valida check (nota between 1.0 and 10.0),
	constraint pk_notas primary key (dni, codigo),

	-- Definir clave ajena en tabla
	constraint fk_notas_asignaturas foreign key (codigo) references cruz.asignaturas (codigo)
							     on delete no action
							     on update cascade
);


