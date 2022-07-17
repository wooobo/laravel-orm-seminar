create table products
(
    id    int          not null,
    name  varchar(255) null,
    price int          null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime default CURRENT_TIMESTAMP not null,
    constraint product_pk
        primary key (id)
);

create table product_options
(
    id         int                                not null,
    product_id int                                not null,
    name       varchar(255)                       null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime default CURRENT_TIMESTAMP not null,
    constraint product_options_pk
        primary key (id)
);


create table categories
(
    id   int not null,
    name int not null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime default CURRENT_TIMESTAMP not null,
    constraint category_pk
        primary key (id)
);


alter table products
    add category_id int not null;


create table orders
(
    id          int not null,
    product_id  int null,
    total_price int null,
    quantity    int null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime default CURRENT_TIMESTAMP not null,
    constraint orders_pk
        primary key (id)
);

