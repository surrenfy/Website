drop database if exists oto;
create database oto;
use oto;
set names utf8;
create table customer (
    email varchar(32) primary key,
    password char(40) not null,
    firstname varchar(32),
    lastname varchar(32),
    gender varchar(16),
    phone varchar(16),
    province varchar (16),
    city varchar (16),
    addr   varchar(256)
);

create table seller (
    email varchar(32) primary key,
    password char(40) not null,
    shopname varchar(32) not null
);

create table deliverer(
    email varchar(32) primary key,
    password char(40) not null,
    firstname varchar(32) not null,
    lastname varchar(32) not null,
    phone varchar(16) not null,
    lastact datetime not null
);

create table message1(               #推送的抢单信息
    deliverer_email varchar(32) not null,
    orders_id  varchar(64) not null
);

create table message2(               #顾客取消的信息
    deliverer_email varchar(32) not null,
    orders_id  varchar(64) not null
);

create table product (
    id           int unsigned not null PRIMARY KEY AUTO_INCREMENT,
    name         varchar(32) not null,
    kind         varchar(32) not null,
    description  varchar(64) not null,
    province     varchar (16) not null,
    city         varchar (16) not null,
    phone        varchar(16) not null,
    addr         varchar(256) not null,
    remarks      varchar(64),
    price        DECIMAL(10,2) not null,
    seller_email varchar(32) not null,
    puttime      datetime not null
);
CREATE UNIQUE INDEX `product_index` on product (name,seller_email);
ALTER TABLE product ADD CONSTRAINT product_fk FOREIGN KEY (seller_email) REFERENCES seller(email);

create table orders (
    id                  varchar(64) PRIMARY KEY ,
    status_id           tinyint unsigned not null,
#0 没发货 1 发货了没人接单 2 接单了还未派送 3 正在派送还没签收 4 已签收 11 顾客取消了
    status              varchar(32)  not null,
    dealtime            datetime     not null,
    overtime            datetime     ,
    customer_email      varchar(32)  not null,
    customer_firstname  varchar(32)  not null,
    customer_lastname   varchar(32)  not null,
    customer_phone      varchar(16)  not null,
    customer_province   varchar (16) not null,
    customer_city       varchar (16) not null,
    customer_addr       varchar(256) not null,
    seller_email        varchar(32)  not null,
    seller_shopname     varchar(32)  not null,
    deliverer_email     varchar(32) ,
    deliverer_firstname varchar(32) ,
    deliverer_lastname  varchar(32) ,
    deliverer_phone     varchar(16) ,
    product_id          int unsigned not null,
    product_name        varchar(32)  not null,
    product_kind        varchar(32)  not null,
    product_description varchar(64)  not null,
    product_price       DECIMAL(10,2) not null,
    product_phone       varchar(16) not null,
    product_province    varchar (16) not null,
    product_city        varchar (16) not null,
    product_addr        varchar(256) not null
);

ALTER TABLE 'orders' ADD INDEX (customer_email);
ALTER TABLE 'orders' ADD INDEX (deliverer_email);
ALTER TABLE 'orders' ADD INDEX (seller_email);

create table administrator (
    id varchar (32) primary key,
    password char(40) not null
)
