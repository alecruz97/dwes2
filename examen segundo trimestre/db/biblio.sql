------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS generos CASCADE;

CREATE TABLE generos
(
    id         bigserial    PRIMARY KEY
  , denom      varchar(255) NOT NULL UNIQUE
  , created_at timestamp(0) NOT NULL DEFAULT current_timestamp
);

DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
    id         bigserial    PRIMARY KEY
  , isbn       varchar(13)  NOT NULL UNIQUE
  , titulo     varchar(255) NOT NULL
  , num_pags   int          CONSTRAINT ck_libros_num_pags_no_negativo
                            CHECK (num_pags >= 0)
  , genero_id  bigint       NOT NULL REFERENCES generos (id)
  , created_at timestamp(0) NOT NULL DEFAULT current_timestamp
);

DROP TABLE IF EXISTS lectores CASCADE;

CREATE TABLE lectores
(
    id            bigserial    PRIMARY KEY
  , numero        varchar(9)   NOT NULL UNIQUE
  , nombre        varchar(255) NOT NULL
  , direccion     varchar(255)
  , poblacion     varchar(255)
  , provincia     varchar(255)
  , codpostal_id  bigint       NOT NULL
  , fecha_nac     date
  , created_at    timestamp(0) NOT NULL DEFAULT current_timestamp
);

-- INSERT INTO lectores (numero, nombre, direccion, codpostal_id, fecha_nac)
-- VALUES ('111', 'Pepe', 'C/. Ancha', 1, '1978-06-02')
--      , ('222', 'María', 'C/. Larga', 1, '1992-10-15')
--      , ('333', 'Antonio', 'C/. Profunda', 1, '1999-02-06');

INSERT INTO generos (denom)
VALUES ('Informática')
     , ('Contabilidad')
     , ('Suspense')
     , ('Terror')
     , ('Fantasía')
     , ('A')
     , ('B')
     , ('C')
     , ('D')
     , ('E')
     , ('F')
     , ('G')
     , ('H')
     , ('I')
     , ('J')
     , ('K')
     , ('L')
     , ('M')
     , ('N')
     , ('Ñ')
     , ('O')
     , ('P')
     , ('Q')
     , ('R')
     , ('S')
     , ('T')
     , ('U')
     , ('V');

INSERT INTO libros (isbn, titulo, num_pags, genero_id)
VALUES ('1111111111111', 'El nombre de la rosa', 760, 3)
     , ('2222222222222', 'Cómo aprender PHP en 24 horas', 12, 1)
     , ('3333333333333', 'Cómo ssdfsdf', 12, 2)
     , ('4444444444444', 'Cómo s3435345345', 12, 2)
     , ('5555555555555', 'Cócxvklxjcvklj23klj4', 12, 1)
