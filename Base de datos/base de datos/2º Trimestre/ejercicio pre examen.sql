drop table if exists cursos cascade;

create table cursos(
    id              bigserial       constraint pk_cursos primary key,
    nombre          varchar(255),
    descripcion     text,
    horas           numeric(4),
    coste           numeric(7,2)
);

drop table if exists ediciones cascade;

create table ediciones(
    id              bigserial       constraint pk_ediciones primary key,
    fecha           date            not null,
    curso_id        bigint          not null constraint fk_ediciones_cursos references cursos (id)
                                             on delete no action on update cascade,
    lugar           varchar(255),
    horario         char            constraint ck_horario_valido check (horario in ('I', 'M', 'T')),
                                    constraint uq_ediciones_debil unique (curso_id, fecha)
);
