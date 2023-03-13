create table public.mailings
(
    id    integer primary key    not null default nextval('mailings_id_seq'::regclass),
    title character varying(255) not null,
    text  text                   not null
);

create table public.send_queue
(
    id         integer primary key   not null default nextval('send_queue_id_seq'::regclass),
    user_id    integer,
    status     character varying(20) not null default 'new',
    mailing_id integer,
    foreign key (mailing_id) references public.mailings (id)
        match simple on update no action on delete no action,
    foreign key (user_id) references public.users (id)
        match simple on update no action on delete no action
);
create index send_queue_status_index on send_queue using btree (status);

create table public.uploaded_files_queue
(
    id            integer primary key    not null default nextval('uploaded_files_queue_id_seq'::regclass),
    filename      character varying(255) not null,
    status        character varying(20)  not null default 'new',
    rows_total    integer,
    rows_imported integer
);
create index index_name on uploaded_files_queue using btree (status);

create table public.users
(
    id        integer primary key   not null default nextval('users_id_seq'::regclass),
    number    character varying(30) not null,
    name      character varying(50) not null,
    import_id integer               not null,
    foreign key (import_id) references public.uploaded_files_queue (id)
        match simple on update no action on delete no action
);
create unique index users_number_uindex on users using btree (number);

create sequence uploaded_files_queue_id_seq
    as integer;

alter sequence uploaded_files_queue_id_seq owner to postgres;

alter sequence uploaded_files_queue_id_seq owned by uploaded_files_queue.id;

create sequence users_id_seq
    as integer;

alter sequence users_id_seq owner to postgres;

alter sequence users_id_seq owned by users.id;

create sequence send_queue_id_seq
    as integer;

alter sequence send_queue_id_seq owner to postgres;

alter sequence send_queue_id_seq owned by send_queue.id;

create sequence mailings_id_seq
    as integer;

alter sequence mailings_id_seq owner to postgres;

alter sequence mailings_id_seq owned by mailings.id;

