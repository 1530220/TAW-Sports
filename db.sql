
create table deporte(
	id int primary key auto_increment,
	nombre varchar(255)
);

create table equipo(
	id int primary key auto_increment,
	nombre varchar(255),
	deporte int,
	foreign key (deporte) references deporte(id)on delete cascade
);

create table jugador(
	id int primary key auto_increment,
	nombre varchar(255),
	email varchar(255),
	equipo int,
	foreign key (equipo) references equipo(id)on delete cascade
);

create table usuarios(
	id int primary key auto_increment,
	nombre varchar(255),
	contraseña varchar(255)
);