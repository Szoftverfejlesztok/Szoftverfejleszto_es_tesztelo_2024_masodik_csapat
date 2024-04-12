

INSERT INTO `userdata` (`user_Id`, `user_name`, `password`, `name_company`, `contact`, `telephone`, `email`, `photo`, `online_availability`, `product_description`, `moderator`, `status`) VALUES
(1, 'kis_vacak', '$2y$10$ed4gsFB5s7g/z', 'Vackok Kft', 'Lepke Pihe', '+36301112233', 'lepke@pihe.hu', NULL, NULL, 'ruha', 0, 2),
(2, 'huci_muci', '54321', 'Méhecske Baltazár', 'Méhecske Baltazár', '+36301112244', 'mehecske@baltazar.hu', NULL, NULL, 'méz', 0, 3);
COMMIT;


INSERT INTO `date_vasar` (`date_id`, `date`, `is_next`) VALUES
(1, '2024-03-17', NULL),
(2, '2024-04-21', NULL),
(3, '2024-05-19', NULL);

INSERT INTO `place` (`place_id`, `place_number`, `place_price`) VALUES
(1, 1, 1500),
(2, 2, 1500),
(3, 3, 1500),
(4, 4, 1500),
(5, 5, 1500),
(6, 6, 1500);

INSERT INTO `reservation` (`reservation_id`, `user_id`, `place_id`, `date_id`, `status`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 1, 0),
(3, 2, 3, 2, 1),
(4, 2, 4, 1, 0),
(5, 1, 1, 2, 1);

INSERT INTO `termek` (`termek_id`, `termek_kategoria`, `user_id`) VALUES
(1, 'méz', 1),
(2, 'vetőmag', 2),
(3, 'kerti szerszám', 2);

INSERT INTO `userdata` (`user_id`, `user_name`, `password`, `name_company`, `contact`, `telephone`, `email`, `photo`, `online_availability`, `product_description`, `moderator`, `status`) VALUES
(1, 'brumm1', 'brumm', 'Brumm Kft', 'Jónás Patrícia', '+36705536254', 'brumm@gmail.com', NULL, 'www.brummkft.hu', 'Termékkínálatunkban többféle méz megtalálható, többek között akác, repce, vegyes virágméz.', 0, 1),
(2, 'kovacsistvan', 'istvan', 'Kovács István egyéni vállalkozó', 'Kovács István', '+36705486325', 'istvankovacs@gmail.com', NULL, 'facebook.com/kovacs.istvan/', 'Kerti szerszámok készítésével foglalkozok. ', 0, 1);


