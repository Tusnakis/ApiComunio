create table jugadores 
	(
		id int(10) not null,
		nombre varchar(30) not null,
		puntos int(3) not null,
		clubid int(10) not null,
		valor int(8) not null,
		situacion varchar(15) not null,
		situacion_info varchar(50),
		posicion varchar(15) not null,
		partidos_jugados int(2) not null,
		constraint pk_jugadores primary key (id),
		constraint fk_jugadores_clubs foreign key (clubid)
		references clubs(id)
	);

create table clubs 
	(
		id int(5) not null,
		nombre varchar(30) not null,
		url varchar(70),
		constraint pk_clubs primary key (id)
	);