-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Már 26. 21:17
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

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kinalat`
--

CREATE TABLE `product_range` (
  `product_range_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `place`
--

CREATE TABLE `place` (
  `place_id` int(11) NOT NULL,
  `place_number` tinyint(4) NOT NULL,
  `place_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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


-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `termek`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;


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


-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `date_vasar`
--
ALTER TABLE `date_vasar`
  ADD PRIMARY KEY (`date_id`);

--
-- A tábla indexei `product_range`
--
ALTER TABLE `product_range`
  ADD PRIMARY KEY (`product_range_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

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
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_category` (`product_category`);

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
-- AUTO_INCREMENT a táblához `kinalat`
--
ALTER TABLE `product_range`
  MODIFY `product_range_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

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
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT a táblához `userdata`
--
ALTER TABLE `userdata`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `kinalat`
--
ALTER TABLE `product_range`
  ADD CONSTRAINT `product_range_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`user_id`),
  ADD CONSTRAINT `product_range_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Megkötések a táblához `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdata` (`user_id`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `place` (`place_id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`date_id`) REFERENCES `date_vasar` (`date_id`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
