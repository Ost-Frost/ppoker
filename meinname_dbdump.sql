-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Dez 2021 um 18:56
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ppoker`
--
CREATE DATABASE IF NOT EXISTS `ppoker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ppoker`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epic`
--

CREATE TABLE `epic` (
  `EpicID` varchar(13) NOT NULL,
  `Name` text NOT NULL,
  `Beschreibung` text NOT NULL,
  `Aufwand` int(11) NOT NULL,
  `Einrichtungsdatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `epic`
--

INSERT INTO `epic` (`EpicID`, `Name`, `Beschreibung`, `Aufwand`, `Einrichtungsdatum`) VALUES
('12345', '12345', 'test search', 457, '2021-11-10'),
('35', '123', '456', 45, '2021-11-09'),
('36', 'los', 'soos', 0, '2021-11-02'),
('61add35d63d9f', '1234556', 'Ich bin lööölig', 0, '2021-12-06');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epicspiel`
--

CREATE TABLE `epicspiel` (
  `EpicID` varchar(13) NOT NULL,
  `SpielID` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `epicspiel`
--

INSERT INTO `epicspiel` (`EpicID`, `SpielID`) VALUES
('35', '111'),
('35', '34354'),
('36', '112'),
('61add35d63d9f', '61add35d6493c');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epicuser`
--

CREATE TABLE `epicuser` (
  `EpicID` varchar(13) NOT NULL,
  `UserID` varchar(13) NOT NULL,
  `UserStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `epicuser`
--

INSERT INTO `epicuser` (`EpicID`, `UserID`, `UserStatus`) VALUES
('35', '61891f1637c', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiele`
--

CREATE TABLE `spiele` (
  `SpielID` varchar(13) NOT NULL,
  `Einrichtungsdatum` date NOT NULL,
  `Task` text NOT NULL,
  `Beschreibung` text NOT NULL,
  `Aufwand` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `spiele`
--

INSERT INTO `spiele` (`SpielID`, `Einrichtungsdatum`, `Task`, `Beschreibung`, `Aufwand`) VALUES
('111', '2021-11-01', 'ertz', 'qwertz', 0),
('112', '2021-11-07', 'leeel', 'mit lool', 0),
('34354', '2021-11-07', '12333', 'lul', 0),
('45654', '2021-11-09', 'Mich selbst terminieren', 'Kopfschuss!!', 0),
('61add35d6493c', '2021-12-06', '42', '123 Hosenbrei', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spielkarte`
--

CREATE TABLE `spielkarte` (
  `SpielID` varchar(13) NOT NULL,
  `UserID` varchar(13) NOT NULL,
  `Karte` int(11) NOT NULL DEFAULT 0,
  `Akzeptiert` tinyint(1) DEFAULT 0,
  `UserStatus` tinyint(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `spielkarte`
--

INSERT INTO `spielkarte` (`SpielID`, `UserID`, `Karte`, `Akzeptiert`, `UserStatus`) VALUES
('111', '61891f1637c', 0, 0, 1),
('112', '61891f1637c', 0, 0, 0),
('34354', '61891f1637c', 0, 0, 0),
('45654', '61891f1637c', 0, 0, 0),
('61add35d6493c', '61891f1637c', 0, 0, 0),
('61add35d6493c', '61adc4107b418', 0, 1, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `UserID` varchar(13) NOT NULL,
  `Username` text NOT NULL,
  `Vorname` text NOT NULL,
  `Nachname` text NOT NULL,
  `Mail` text NOT NULL,
  `Passwort` text NOT NULL,
  `Registrierungsdatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Vorname`, `Nachname`, `Mail`, `Passwort`, `Registrierungsdatum`) VALUES
('123', 'PetersPopel69', 'Peter', 'Popelkopf', 'Peter.Popel@gmail.com', '123', '2021-11-01'),
('3456', 'tttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt', 'Ole \"fucking\"', 'Reimers', 'ole.reimers@fujitsu.com', 'ole123', '2021-11-07'),
('6188125006f', 'PeterPenis420', 'Peter', 'Penis', 'peter.penis@steif.com', '$2y$10$bECr4eHy6MqXxZxkw.plUeZoSeOoR.JWLklqfIxEvg4Agm0TEf/Ea', '2021-11-07'),
('61891f1637c', 'FLX', 'Felix', 'Schmeißer', 'felixmichael.schmeisser@fujitsu.com', '$2y$10$oDpVTE54FyQeHlnXKIoA7O6b2.KD249Y8iuHWZET.rPTszEacASJe', '2021-11-08'),
('61adc4107b418', 'PeterPenis69', 'Felix', 'Schmeißer', 'felix.schmeisser@fujitsu.com', '$2y$10$8r1ZX7KD/neXbynlh2Vnl.lhHVpstDXloa7vT2Eshu5Mx.HzxyJzG', '2021-12-06');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `epic`
--
ALTER TABLE `epic`
  ADD PRIMARY KEY (`EpicID`);

--
-- Indizes für die Tabelle `epicspiel`
--
ALTER TABLE `epicspiel`
  ADD PRIMARY KEY (`EpicID`,`SpielID`) USING BTREE,
  ADD KEY `SpielID` (`SpielID`);

--
-- Indizes für die Tabelle `epicuser`
--
ALTER TABLE `epicuser`
  ADD PRIMARY KEY (`EpicID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indizes für die Tabelle `spiele`
--
ALTER TABLE `spiele`
  ADD PRIMARY KEY (`SpielID`);

--
-- Indizes für die Tabelle `spielkarte`
--
ALTER TABLE `spielkarte`
  ADD PRIMARY KEY (`SpielID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `epicspiel`
--
ALTER TABLE `epicspiel`
  ADD CONSTRAINT `epicspiel_ibfk_1` FOREIGN KEY (`EpicID`) REFERENCES `epic` (`EpicID`) ON DELETE CASCADE,
  ADD CONSTRAINT `epicspiel_ibfk_2` FOREIGN KEY (`SpielID`) REFERENCES `spiele` (`SpielID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `epicuser`
--
ALTER TABLE `epicuser`
  ADD CONSTRAINT `epicuser_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `epicuser_ibfk_2` FOREIGN KEY (`EpicID`) REFERENCES `epic` (`EpicID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `spielkarte`
--
ALTER TABLE `spielkarte`
  ADD CONSTRAINT `spielkarte_ibfk_1` FOREIGN KEY (`SpielID`) REFERENCES `spiele` (`SpielID`) ON DELETE CASCADE,
  ADD CONSTRAINT `spielkarte_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
