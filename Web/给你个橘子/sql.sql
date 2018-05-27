create database web4;

use web4;

create table user(
    username varchar(32) not null,
    password varchar(32) not null
);

create table session(
    session_id char(32) not null primary key,
    ip varchar(30),
    data varchar(100)
);

insert into user value('admin', '0192023A7BBD73250516F069DF18B500');

create user 'yiruma'@'localhost' identified by 'kaoyanyaojin';
grant all privileges on `web4`.* to 'yiruma'@'localhost' identified by 'kaoyanyaojin';
