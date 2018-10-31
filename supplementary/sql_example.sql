DROP DATABASE IF EXISTS yaddax3;

CREATE DATABASE yaddax3;
USE yaddax3;

-- create table user (
--           firstname varchar(32) not null,
--           lastname varchar(32) not null,
--           email varchar(64) not null,
--           id varchar(16) not null,
--           password blob not null,
--           activated boolean default false,
--
--           unique(email),
--           primary key(id)
-- );
--
-- create table listensto (
--             uida varchar(16) not null,
--             uidb varchar(16) not null,
--
--             primary key(uida, uidb),
--             foreign key(uida) references user(id)
-- );
--
-- create table image (
--             id int not null auto_increment,
--             uid varchar(16) not null,
--             img blob not null,
--
--             primary key(id),
--             foreign key(uid) references user(id)
-- );
-- create table yaddarelation (
--             uida varchar(16) not null,
--             uidb varchar(16) not null,
--             dateintimea varchar(32) not null,
--             dateintimeb varchar(32) not null,
--
--             primary key(uida, dateintimea)
-- );
-- create table yadda (
--             dateintime datetime not null,
--             uid varchar(16) not null,
--             content varchar(167) not null,
--
--             primary key(uid, dateintime),
--             foreign key (uid, dateintime) yaddarelation(uida, dateintimea)
-- );
-- create table imgrelation (
--             iid int not null,
--             uid varchar(16) not null,
--             dateintime datetime not null,
--
--             primary key (iid, uid, dateintime),
--             foreign key(dateintime, uid) references yadda(dateintime, uid)
-- );
-- ------------------------------------------------------------------------------


-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Vært: localhost
-- Genereringstid: 30. 10 2018 kl. 11:56:31
-- Serverversion: 10.1.36-MariaDB
-- PHP-version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `uid` varchar(16) NOT NULL,
  `img` blob NOT NULL,
  `type` enum('noIMG', 'ProfileIMG','YaddaIMG') NOT NULL default 'noIMG'

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `imgrelation`
--

CREATE TABLE `imgrelation` (
  `iid` int(11) NOT NULL,
  `uid` varchar(16) NOT NULL,
  `dateintime` datetime default current_timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `listensto`
--

CREATE TABLE `listensto` (
  `uida` varchar(16) NOT NULL,
  `uidb` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user`
--

CREATE TABLE `user` (
  `id` varchar(16) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` blob NOT NULL,
  `activated` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `yadda`
--

CREATE TABLE `yadda` (
  `dateintime` datetime default current_timestamp NOT NULL,
  `uid` varchar(16) NOT NULL,
  `content` varchar(167) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `yaddarelation`
--

CREATE TABLE `yaddarelation` (
  `uida` varchar(16) NOT NULL,
  `uidb` varchar(16) NOT NULL,
  `dateintimea` datetime default current_timestamp NOT NULL,
  `dateintimeb` datetime default current_timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indeks for tabel `imgrelation`
--
ALTER TABLE `imgrelation`
  ADD PRIMARY KEY (`iid`,`uid`,`dateintime`),
  ADD KEY `uid` (`uid`,`dateintime`);

--
-- Indeks for tabel `listensto`
--
ALTER TABLE `listensto`
  ADD PRIMARY KEY (`uida`,`uidb`);

--
-- Indeks for tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks for tabel `yadda`
--
ALTER TABLE `yadda`
  ADD PRIMARY KEY (`uid`,`dateintime`);

--
-- Indeks for tabel `yaddarelation`
--
ALTER TABLE `yaddarelation`
  ADD PRIMARY KEY (`uida`,`dateintimea`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`);

--
-- Begrænsninger for tabel `imgrelation`
--
ALTER TABLE `imgrelation`
  ADD CONSTRAINT `imgrelation_ibfk_1` FOREIGN KEY (`uid`,`dateintime`) REFERENCES `yadda` (`uid`, `dateintime`);

--
-- Begrænsninger for tabel `listensto`
--
ALTER TABLE `listensto`
  ADD CONSTRAINT `listensto_ibfk_1` FOREIGN KEY (`uida`) REFERENCES `user` (`id`);

--
-- Begrænsninger for tabel `yaddarelation`
--
ALTER TABLE `yaddarelation`
  ADD CONSTRAINT `yaddarelation_ibfk_1` FOREIGN KEY (`uida`,`dateintimea`) REFERENCES `yadda` (`uid`, `dateintime`);

-- Inserts
  insert into user(id, firstname, lastname, email, password, activated)
    values('Kasse', 'Kasper', 'Mortensen', 'store@kasse.com', '123', 1),
          ('Drillz', 'Drilon', 'Braha', 'eteller@andet.dk', '123', 0);

  insert into listensto(uida, uidb)
    values('Drillz', 'Kasse');

  insert into image(uid, img, type)
    values('Kasse', 'test', 'profileIMG'),
          ('Drillz', 'test', 'noIMG'),
          ('Drillz', 'test', 'yaddaIMG');

  insert into yadda(uid, dateintime, content)
    values('Kasse', '2018-10-25 12:52:20', 'blablabla'),
          ('Drillz', '2014-10-24 12:52:10', 'blablabla...'),
          ('Drillz', '2015-10-24 12:52:11', 'Store kasser');

  insert into imgrelation(iid, uid, dateintime)
    values(1, 'Kasse', '2018-10-25 12:52:20'),
          (2, 'Drillz', '2014-10-24 12:52:10'),
          (3, 'Drillz', '2014-10-24 12:52:10');

  insert into yaddarelation(uida, dateintimea, uidb, dateintimeb)
    values('Kasse', '2018-10-25 12:52:20', 'Drillz', '2015-10-24 12:52:11');


COMMIT;
