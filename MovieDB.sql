
use normanbrorsen_dk_db;
SET default_storage_engine = `InnoDB`;

DROP table if exists seatReservation;
DROP table if exists seat;
DROP table if exists screening;
DROP table if exists auditorium;
DROP table if exists reservation;
DROP table if exists movie;
DROP table if exists user;
DROP table if exists news;
DROP table if exists contact_message;
DROP table if exists spam_message;

create table user (
  userID int not null primary key auto_increment,
  lastName varchar(100) not null,
  firstName varchar(100) not null,
  DOB date,
  email varchar(100) not null unique,
  password varchar(100) not null,
  gender varchar(1) not null,
  role varchar(20) not null default 'customer'
);

create table movie(
    movieID int not null primary key auto_increment,
    title varchar(100) not null,
    poster_url varchar(255) not null,
    description varchar(255) not null,
    released date,
    duration_min int,
    age_limit int
);

create table reservation(
    reservationID int not null primary key auto_increment,
    userID int not null,
    reservation_date date not null,
    total_price decimal(10,2) not null,
    foreign key (userID) references user(userID)
);

create table auditorium(
    auditoriumID int not null primary key auto_increment,
    name varchar(100) not null
);

create table screening(
    screeningID int not null primary key auto_increment,
    movieID int not null,
    auditoriumID int not null,
    screening_time datetime not null,
    price decimal(10,2) not null,
    foreign key (movieID) references movie(movieID),
    foreign key (auditoriumID) references auditorium(auditoriumID)
);

create table seat(
    seatID int not null primary key auto_increment,
    auditoriumID int not null,
    rowNo int not null,
    seatNo int not null,
    foreign key (auditoriumID) references auditorium(auditoriumID)
);

create table seatReservation(
    reservationID int not null,
    seatID int not null,
    constraint pk_seatReservation primary key (reservationID, seatID),
    foreign key (reservationID) references reservation(reservationID),
    foreign key (seatID) references seat(seatID)
);

create table news(
    newsID int not null primary key auto_increment,
    title varchar(100) not null,
    content text not null,
    published_date date not null
);

CREATE TABLE contact_message (
    messageID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    sent_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE spam_message (
    messageID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    attempted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
   