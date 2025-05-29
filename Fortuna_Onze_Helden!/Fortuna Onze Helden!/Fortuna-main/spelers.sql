-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 nov 2021 om 00:10
-- Serverversie: 10.4.17-MariaDB
-- PHP-versie: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fortunamusea`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `spelers`
--

CREATE TABLE `spelers` (
  `id` int(255) NOT NULL,
  `achternaam` varchar(60) NOT NULL,
  `voornaam` varchar(60) NOT NULL,
  `seizoenen` varchar(255) DEFAULT NULL,
  `afbeelding` varchar(255) DEFAULT NULL,
  `nationaliteit` varchar(60) DEFAULT NULL,
  `geboortedatum` date DEFAULT NULL,
  `geboorteplaats` varchar(255) DEFAULT NULL,
  `sterfdatum` date DEFAULT NULL,
  `positie` varchar(255) DEFAULT NULL,
  `debuut` varchar(255) DEFAULT NULL,
  `ookgespeeldvoor` varchar(255) DEFAULT NULL,
  `bijzonderheden` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `spelers`
--

INSERT INTO `spelers` (`id`, `achternaam`, `voornaam`, `seizoenen`, `afbeelding`, `nationaliteit`, `geboortedatum`, `geboorteplaats`, `sterfdatum`, `positie`, `debuut`, `ookgespeeldvoor`, `bijzonderheden`) VALUES
(1, 'Dammer', 'Wessel', '2017-2018 t/m 2019-2020', '', 'Nederlands', '1995-03-01', 'Duitsland', NULL, 'Verdediger', '2017/2018', 'SC Cambuur; Feyenoord; FC Groningen', 'Was aanvoeder in 2018/2019'),
(2, 'Semedo', 'Lisandro', 'Gegevens worden opgehaald. Wacht een paar seconden en knip of kopieer vervolgens opnieuw.', NULL, 'Portugees - Kaapverdisch', '1996-03-12', 'Setubal(Por)', NULL, 'Aanvaller', '2017/2018', 'Ofi Kreta; AE Zakakiou', NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `spelers`
--
ALTER TABLE `spelers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `spelers'
--
ALTER TABLE `spelers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
