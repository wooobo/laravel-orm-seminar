create table products
(
    id    int          not null,
    name  varchar(255) null,
    price int          null,
    constraint product_pk
        primary key (id)
);


create table categories
(
    id   int not null,
    name int not null,
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
    constraint orders_pk
        primary key (id)
);

