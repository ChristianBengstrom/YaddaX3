DROP DATABASE IF EXISTS worldtest;

CREATE DATABASE worldtest;
USE worldtest;

create table contry(
      code char(2) not null,
      gnp int not null,
      region varchar(40) not null,
      continent enum('asia','europe','north america','africa',
                 'oceania','antarctica','south america')
                    not null default 'asia',
      gnpold int not null,
      surfacearea float(10.2) not null,
      name varchar(40) not null,
      localname varchar(40) not null,
      population int not null,
      endepyear year not null,
      lifeexpectancy float(3.1) not null,
      govermentform varchar(40) not null,
      headofstate varchar(40) not null,
      capital varchar(40) not null,
      -- code2 char(2) not null,

      primary key(code),
      unique(capital)
);

create table city(
      id int not null auto_increment,
      district varchar(40) not null,
      name varchar(40) not null,
      population int unsigned not null,
      contrycode char(2) not null,

      primary key(id),
      foreign key(contrycode) references contry(code)
);

create table contrylanguage(
      contrycode char(2) not null,
      language varchar(40) not null,
      isofficial boolean not null,
      percantage numeric(3,2) not null
        check(percantage between 0.00 and 100.00),

      primary key(contrycode, language)
);

create table speaks (
  code char(2) not null,
  contrycode char(2) not null,
  language varchar(40) not null,

  primary key(code, language, contrycode),
  foreign key(code) references contry(code) on delete cascade,
  foreign key(contrycode, language) references contrylanguage(contrycode, language) on delete cascade
);

-- TEST HERE.

insert into contry values('DK', 9999, 'Sønderjylland', 'EU', 9995, 100000, 'Denmark', 'Danmark', 5500000, 1200, 99, 'Demokrati', 'Lars Løkke', 'Copenhagen');

insert into city(district, name, population, contrycode)
  values('Sydbyen', 'Kolding', 60000, 'DK'),
        ('Centrum', 'Aarhus', 810000, 'DK'),
        ('Centrum', 'Broager', 61100, 'DK'),
        ('Oest', 'Sonderborg', 64000, 'DK'),
        ('Vest', 'Esbjerg', 67100, 'DK');

  insert into contrylanguage(contrycode, language, isofficial, percantage)
    values('DK', 'Dansk', true, '85'),
          ('EN', 'Engelsk', true, '10');


-- NEW
DROP DATABASE IF EXISTS yaddax3;

CREATE DATABASE yaddax3;
USE yaddax3;

create table user (
    firstname varchar(32) not null,
    lastname varchar(32) not null,
    email varchar(64) not null,
    uid varchar(16) not null,
    password blob not null,
    activated boolean default false,
    unique(email),
    primary key(uid)
);

create table listensto (
            uida varchar(16) not null,
            uidb varchar(16) not null,
            primary key(uida, uidb)
);

create table image (
            id int not null auto_increment,
            img blob not null,
            primary key(id)
);

create table yadda (
            dateintime datetime not null default current_timestamp,
            uid varchar(16) not null,
            content varchar(167) not null,
            primary key(uid, dateintime)
);

create table yaddarelation (
            uida varchar(16) not null,
            uidb varchar(16) not null,
            datetimea varchar(16) not null,
            datetimeb varchar(16) not null,
            primary key(uida, uidb)
);
