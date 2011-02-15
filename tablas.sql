create table taringarss ( 
id smallint(10) unsigned not null auto_increment, 
title varchar(100) not null, 
link varchar(200) not null , 
pubdate varchar(50) not null, 
category varchar(30) not null,
comments varchar(200) not null,
description varchar(1500) not null,
primary key (id), 
key (title,link) 
);
