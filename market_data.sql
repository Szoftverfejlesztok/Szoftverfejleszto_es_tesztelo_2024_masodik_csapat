-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2024. Ápr 30. 21:21
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
-- Adatbázis: `market`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `date_market`
--

CREATE TABLE `date_market` (
  `date_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `is_next` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `date_market`
--

INSERT INTO `date_market` (`date_id`, `date`, `is_next`) VALUES
(1, '2024-04-21', 0),
(2, '2024-05-19', 1),
(3, '2024-06-16', 0),
(4, '2024-07-21', 0),
(5, '2024-08-18', 0),
(6, '2024-09-15', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `place`
--

CREATE TABLE `place` (
  `place_id` int(11) NOT NULL,
  `place_number` varchar(10) NOT NULL,
  `place_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `place`
--

INSERT INTO `place` (`place_id`, `place_number`, `place_price`) VALUES
(1, 'I/1', 1500),
(2, 'I/2', 1500),
(3, 'I/3', 1500),
(4, 'I/4', 1500),
(5, 'I/5', 1500),
(6, 'I/6', 1500),
(7, 'I/7', 1500),
(8, 'I/8', 1500),
(9, 'I/9', 1500),
(10, 'I/10', 1500),
(11, 'I/11', 1500),
(12, 'I/12', 1500),
(13, 'II/1', 1500),
(14, 'II/2', 1500),
(15, 'II/3', 1500),
(16, 'II/4', 1500),
(17, 'II/5', 1500),
(18, 'II/6', 1500),
(19, 'II/7', 1500),
(20, 'II/8', 1500),
(21, 'II/9', 1500),
(22, 'II/10', 1500),
(23, 'II/11', 1500),
(24, 'II/12', 1500),
(25, 'III/1', 1500),
(26, 'III/2', 1500),
(27, 'III/3', 1500),
(28, 'III/4', 1500),
(29, 'III/5', 1500),
(30, 'III/6', 1500),
(31, 'III/7', 1500),
(32, 'III/8', 1500),
(33, 'III/9', 1500),
(34, 'III/10', 1500),
(35, 'III/11', 1500),
(36, 'III/12', 1500),
(37, 'IV/1', 1500),
(38, 'IV/2', 1500),
(39, 'IV/3', 1500),
(40, 'IV/4', 1500),
(41, 'IV/5', 1500),
(42, 'IV/6', 1500),
(43, 'IV/7', 1500),
(44, 'IV/8', 1500),
(45, 'IV/9', 1500),
(46, 'IV/10', 1500),
(47, 'IV/11', 1500),
(48, 'IV/12', 1500),
(49, 'V/1', 1500),
(50, 'V/2', 1500),
(51, 'V/3', 1500),
(52, 'V/4', 1500),
(53, 'V/5', 1500),
(54, 'V/6', 1500),
(55, 'V/7', 1500),
(56, 'V/8', 1500),
(57, 'V/9', 1500),
(58, 'V/10', 1500),
(59, 'V/11', 1500),
(60, 'V/12', 1500),
(61, 'VI/1', 1500),
(62, 'VI/2', 1500),
(63, 'VI/3', 1500),
(64, 'VI/4', 1500),
(65, 'VI/5', 1500),
(66, 'VI/6', 1500),
(67, 'VI/7', 1500),
(68, 'VI/8', 1500),
(69, 'VI/9', 1500),
(70, 'VI/10', 1500),
(71, 'VI/11', 1500),
(72, 'VI/12', 1500),
(73, 'VII/1', 1500),
(74, 'VII/2', 1500),
(75, 'VII/3', 1500),
(76, 'VII/4', 1500),
(77, 'VII/5', 1500),
(78, 'VII/6', 1500),
(79, 'VII/7', 1500),
(80, 'VII/8', 1500),
(81, 'VII/9', 1500),
(82, 'VII/10', 1500),
(83, 'VII/11', 1500),
(84, 'VII/12', 1500),
(85, 'VIII/1', 1500),
(86, 'VIII/2', 1500),
(87, 'VIII/3', 1500),
(88, 'VIII/4', 1500),
(89, 'VIII/5', 1500),
(90, 'VIII/6', 1500),
(91, 'VIII/7', 1500),
(92, 'VIII/8', 1500),
(93, 'VIII/9', 1500),
(94, 'VIII/10', 1500),
(95, 'VIII/11', 1500),
(96, 'VIII/12', 1500);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `product`
--

INSERT INTO `product` (`product_id`, `product_category`) VALUES
(21, 'Állateledel'),
(37, 'Ásvány'),
(34, 'Babaholmi'),
(22, 'Babaruha'),
(2, 'Bőr'),
(36, 'Bőráru'),
(8, 'Cipő'),
(19, 'Édesség'),
(5, 'Ékszer'),
(7, 'Élelmiszer'),
(29, 'Faipari termék'),
(17, 'Fűszer'),
(20, 'Gyógynövény'),
(12, 'Gyümölcs'),
(13, 'Hal'),
(14, 'Hús'),
(32, 'Játék'),
(23, 'Kávé'),
(25, 'Kerámia'),
(4, 'Kerti szerszám'),
(28, 'Kézműves szappan'),
(9, 'Kézműves tárgy'),
(1, 'Méz'),
(38, 'Népi kézműves termék'),
(27, 'Növény'),
(31, 'Óra'),
(39, 'Pálinka'),
(30, 'Régiség'),
(6, 'Ruhanemű'),
(16, 'Sajt'),
(15, 'Szendvics'),
(33, 'Szobanövény'),
(10, 'Szőnyeg'),
(26, 'Táska'),
(24, 'Tea'),
(35, 'Tűzzománc'),
(3, 'Vetőmag'),
(18, 'Virág'),
(11, 'Zöldség');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `product_range`
--

CREATE TABLE `product_range` (
  `product_range_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `product_range`
--

INSERT INTO `product_range` (`product_range_id`, `product_id`, `user_id`) VALUES
(1, 1, 1),
(2, 5, 2),
(3, 11, 3),
(4, 26, 4),
(5, 11, 5),
(6, 12, 5),
(7, 25, 6),
(8, 38, 6),
(9, 2, 7),
(10, 26, 7),
(15, 39, 10),
(16, 34, 11),
(17, 6, 11),
(18, 25, 9),
(19, 9, 9),
(20, 35, 9),
(21, 19, 8),
(22, 20, 8),
(23, 27, 8),
(24, 24, 8),
(25, 11, 8);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `date_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `user_id`, `place_id`, `date_id`, `status`) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 3, 1),
(3, 3, 12, 2, 1),
(4, 4, 27, 1, 1),
(5, 5, 32, 4, 1),
(6, 6, 28, 1, 1),
(7, 7, 36, 1, 1),
(8, 8, 29, 1, 1),
(9, 9, 42, 1, 1),
(10, 10, 55, 1, 1),
(11, 11, 58, 1, 1),
(12, 1, 1, 2, 1),
(13, 2, 2, 2, 1),
(14, 3, 12, 1, 1),
(15, 4, 27, 3, 1),
(16, 5, 32, 2, 1),
(17, 6, 28, 2, 1),
(18, 7, 36, 1, 1),
(19, 8, 29, 5, 1),
(20, 9, 42, 4, 0),
(21, 10, 55, 2, 1),
(22, 11, 58, 1, 1),
(23, 9, 17, 4, 1),
(24, 9, 89, 3, 1),
(25, 6, 89, 4, 1),
(26, 1, 93, 3, 0),
(27, 8, 92, 4, 1),
(28, 8, 36, 6, 0),
(29, 8, 80, 5, 1),
(30, 8, 7, 5, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `userdata`
--

CREATE TABLE `userdata` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(80) NOT NULL,
  `name_company` varchar(50) NOT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `online_availability` varchar(500) DEFAULT NULL,
  `product_description` varchar(300) NOT NULL,
  `moderator` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `userdata`
--

INSERT INTO `userdata` (`user_id`, `user_name`, `password`, `name_company`, `contact`, `telephone`, `email`, `online_availability`, `product_description`, `moderator`, `status`) VALUES
(1, 'brumm1', '$2y$10$MrZyYfqK09DRvuvG/YouSuYo4MtRxYi4eWlopz6s41QtWdkMhm4qG', 'Brumm Kft', 'Jónás Patrícia', '06705536254', 'brumm@gmail.com', 'https://www.brummkft.hu', 'Termékkínálatunkban többféle méz megtalálható, többek között akác, repce, vegyes virágméz.', 1, 1),
(2, 'kovacspeter', '$2y$10$vOkt7.EcNH/C5Tull.DNmuuJQDmngZ34ttsuMfprSlLy1FlrqHpFS', 'AranyKéz', 'Kovács Péter', '06303456789', 'kovacspeter1@example.com', 'https://www.facebook.com/AranyKéz', 'Kézműves ékszerek különleges alkotások és egyedi darabok', 0, 1),
(3, 'nagymaria', '$2y$10$keg5RS0LwNaXowr3EuCgi.eYgZpt9fBy/OFGKvMtt88jjUkKUxt9m', 'EcoBioTermék', 'Nagy Mária', '06207654321', 'nagymaria2@example.com', 'https://www.facebook.com/EcoBioTermék', 'Biogazdálkodásból származó termékek, organikus konyhai alapanyagok és higiéniai termékek', 0, 1),
(4, 'kissgeza', '$2y$10$jzhI8nk25ppJU9CFH9.OyeQLvc7y.p/IkJRSQUn.LcUO66.SvpkHG', 'ZöldKert', 'Kiss Géza', '06701222333', 'kissgeza3@example.com', 'https://www.facebook.com/ZöldKert', 'Kerti növények, virágok és díszfák, kertészeti eszközök és kiegészítők', 0, 1),
(5, 'tothistvan', '$2y$10$jWzoQ2JwfZmegTz6pYssp.eF8hvWBxv0hXdzpKosryPwG.IDdMpQu', 'Gazdakör', 'Tóth István', '06304555666', 'tothistvan4@example.com', 'https://www.facebook.com/Gazdakör', 'Friss zöldségek, gyümölcsök és szezonális termények közvetlenül a termelőtől', 0, 0),
(6, 'szabolaura', '$2y$10$HLwGZWlOHr.L5YdNPyb8be.NrYVnHLOl.pC/HLYsdljl1aewpEyei', 'MűvészKuckó', 'Szabó Laura', '06707888999', 'szabolaura5@example.com', 'https://www.facebook.com/MűvészKuckó', 'Festmények, művészeti alkotások és díszítőelemek, egyedi ajándéktárgyak', 0, 1),
(7, 'horvathandrea', '$2y$10$ZCUEVEEyZs.3yL.8UOfqbehKUk7KSm/yJxXPY.2dSBtyJSq13jg0G', 'BőrVilág', 'Horváth Andrea', '06303123123', 'horvathandrea6@example.com', 'https://www.facebook.com/BőrVilág', 'Kézzel készített bőröndök, táska és kiegészítők, prémium minőségű bőrtermékek', 0, 0),
(8, 'molnaristvan', '$2y$10$DJMhKhmH0F1B5OWpywwgX.lPpBgXVwkuV.ML3csQChub9xShKl/mi', 'GyógyFűszerek', 'Molnár István', '06705646456', 'molnaristvan7@example.com', 'https://www.facebook.com/GyógyFűszerek', 'Gyógyító hatású fűszerek, teakeverékek és gyógynövények, természetes gyógymódok', 0, 1),
(9, 'feherkata', '$2y$10$fdgk7fYLb7NmaXa7IeRXAuNQ3en3ojY4YLtalXXCBBHpTJ1H0y1xm', 'KerámiaMania', 'Fehér Kata', '06309789789', 'feherkata8@example.com', 'https://www.facebook.com/KerámiaMania', 'Kézzel készített kerámia díszek, egyedi cseréptárgyak és dekorációs elemek', 0, 1),
(10, 'bakosbalazs', '$2y$10$5wAAK4nMh2yYCeeUXdvwr.IJACoQ15lp3i5TnvfgGojp4ta4hdbrW', 'PálinkaPince', 'Bakos Balázs', '06202132321', 'bakosbalazs9@example.com', 'https://www.facebook.com/PálinkaPince', 'Különleges ízű házi pálinkák, prémium minőségű gyümölcsből lepárolva', 0, 0),
(11, 'galreka', '$2y$10$xK/GroI5EQFY6RqgChoWxuF7EpY5YH/DLc91UnFFrEs523mGhXe2W', 'TextilTrend', 'Gál Réka', '06705465454', 'galreka10@example.com', 'https://www.facebook.com/TextilTrend', 'Kézzel készített textíliák, szőttesek és ruhaneműk, valamint babaholmik', 0, 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `date_market`
--
ALTER TABLE `date_market`
  ADD PRIMARY KEY (`date_id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- A tábla indexei `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`place_id`);

--
-- A tábla indexei `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_category` (`product_category`);

--
-- A tábla indexei `product_range`
--
ALTER TABLE `product_range`
  ADD PRIMARY KEY (`product_range_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- A tábla indexei `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `date_id` (`date_id`);

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
-- AUTO_INCREMENT a táblához `date_market`
--
ALTER TABLE `date_market`
  MODIFY `date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `place`
--
ALTER TABLE `place`
  MODIFY `place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT a táblához `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT a táblához `product_range`
--
ALTER TABLE `product_range`
  MODIFY `product_range_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT a táblához `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT a táblához `userdata`
--
ALTER TABLE `userdata`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `product_range`
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
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`date_id`) REFERENCES `date_market` (`date_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
