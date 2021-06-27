User Table:

create table users (id int(10) unsigned not null auto_increment, username varchar(25) not null, password varchar(128) not null, email varchar(60) not null, primary key (id), unique key username (username)) engine=InnoDB
