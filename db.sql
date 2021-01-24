CREATE DATABASE store;

CREATE TABLE users(
    id int not null auto_increment PRIMARY key,
    name varchar(80),
    email varchar(80) UNIQUE,
    password char(32)
);