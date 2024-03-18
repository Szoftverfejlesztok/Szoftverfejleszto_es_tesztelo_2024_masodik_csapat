-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Már 18. 21:29
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `vasar`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `date_vasar`
--

CREATE TABLE `date_vasar` (
  `date_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `is_next` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `date_vasar`
--

/*INSERT INTO `date_vasar` (`date_id`, `date`, `is_next`) VALUES
(1, '2024-03-17', NULL),
(2, '2024-04-21', NULL),
(3, '2024-05-19', NULL);*/

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `place`
--

CREATE TABLE `place` (
  `place_id` int(11) NOT NULL,
  `place_number` tinyint(4) NOT NULL,
  `place_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `place`
--

/*INSERT INTO `place` (`place_id`, `place_number`, `place_price`) VALUES
(1, 1, 1500),
(2, 2, 1500),
(3, 3, 1500),
(4, 4, 1500),
(5, 5, 1500),
(6, 6, 1500);*/

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `date_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `reservation`
--

/*INSERT INTO `reservation` (`reservation_id`, `user_id`, `place_id`, `date_id`, `status`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 1, 0),
(3, 2, 3, 2, 1),
(4, 2, 4, 1, 0),
(5, 1, 1, 2, 1);*/

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek`
--

CREATE TABLE `termek` (
  `termek_id` int(11) NOT NULL,
  `termek_kategoria` varchar(30) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `termek`
--

/*INSERT INTO `termek` (`termek_id`, `termek_kategoria`, `user_id`) VALUES
(1, 'méz', 1),
(2, 'vetőmag', 2),
(3, 'kerti szerszám', 2);*/

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `userdata`
--

CREATE TABLE `userdata` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name_company` varchar(50) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `online_availability` varchar(500) DEFAULT NULL,
  `product_description` varchar(300) NOT NULL,
  `moderator` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `userdata`
--

/*INSERT INTO `userdata` (`user_id`, `user_name`, `password`, `name_company`, `contact`, `telephone`, `email`, `photo`, `online_availability`, `product_description`, `moderator`, `status`) VALUES
(1, 'brumm1', 'brumm', 'Brumm Kft', 'Jónás Patrícia', '+36705536254', 'brumm@gmail.com', NULL, 'www.brummkft.hu', 'Termékkínálatunkban többféle méz megtalálható, többek között akác, repce, vegyes virágméz.', 0, 1),
(2, 'kovacsistvan', 'istvan', 'Kovács István egyéni vállalkozó', 'Kovács István', '+36705486325', 'istvankovacs@gmail.com', NULL, 'facebook.com/kovacs.istvan/', 'Kerti szerszámok készítésével foglalkozok. ', 0, 1);*/

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `date_vasar`
--
ALTER TABLE `date_vasar`
  ADD PRIMARY KEY (`date_id`);

--
-- A tábla indexei `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`place_id`);

--
-- A tábla indexei `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `date_id` (`date_id`);

--
-- A tábla indexei `termek`
--
ALTER TABLE `termek`
  ADD PRIMARY KEY (`termek_id`),
  ADD UNIQUE KEY `termek_kategoria` (`termek_kategoria`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `date_vasar`
--
ALTER TABLE `date_vasar`
  MODIFY `date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `place`
--
ALTER TABLE `place`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `termek`
--
ALTER TABLE `termek`
  MODIFY `termek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `userdata`
--
ALTER TABLE `userdata`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`user_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `place` (`place_id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`date_id`) REFERENCES `date_vasar` (`date_id`);

--
-- Megkötések a táblához `termek`
--
ALTER TABLE `termek`
  ADD CONSTRAINT `termek_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
