-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 17 jun 2022 om 11:40
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_mms`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorieen`
--

CREATE TABLE `categorieen` (
  `id` int(11) NOT NULL,
  `beschrijving` varchar(100) NOT NULL,
  `naam` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `categorieen`
--

INSERT INTO `categorieen` (`id`, `beschrijving`, `naam`) VALUES
(1, 'Wanneer iets kapot is', 'Kapot'),
(3, 'Wanneer er sprake is van overlast, kies voor deze categorie', 'Overlast');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `achternaam` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefoonnummer` varchar(100) NOT NULL,
  `geboortedatum` date NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `voornaam`, `achternaam`, `email`, `telefoonnummer`, `geboortedatum`, `wachtwoord`, `rol`) VALUES
(1, 'Lisa', 'Drommel', 'lisahakhoff@ziggo.nl', '0614782233', '1995-06-15', '$2y$10$xEgJzfqQXsimHEuwHZ7TwebD9/Je2ooQa1Wi58.XS2fC.6Y4l9AiG', 'medewerker'),
(4, 'Test', 'Test', 'test1325123@test.nl', '12324052149', '1991-11-11', '', 'gebruiker');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `meldingen`
--

CREATE TABLE `meldingen` (
  `id` int(11) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `personeel_id` int(11) DEFAULT NULL,
  `titel` varchar(100) NOT NULL,
  `datum` datetime NOT NULL,
  `opmerking` text NOT NULL,
  `status` enum('gesloten','verwerken') NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `bericht` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `meldingen`
--

INSERT INTO `meldingen` (`id`, `gebruiker_id`, `personeel_id`, `titel`, `datum`, `opmerking`, `status`, `categorie_id`, `bericht`) VALUES
(61, 1, 1, '123123', '2022-06-16 12:58:18', 'xxwxwx', 'gesloten', 1, '121212'),
(62, 1, 1, 'De tv van de buren dreunt door', '2022-06-16 17:17:52', 'De buren zullen de tv zachter zetten na 21.30.', 'gesloten', 3, 'Door het geluid kan ik niet slapen');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `categorieen`
--
ALTER TABLE `categorieen`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `meldingen`
--
ALTER TABLE `meldingen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meldingen_ibfk_1` (`gebruiker_id`),
  ADD KEY `meldingen_ibfk_2` (`categorie_id`),
  ADD KEY `meldingen_ibfk_3` (`personeel_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `categorieen`
--
ALTER TABLE `categorieen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `meldingen`
--
ALTER TABLE `meldingen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
