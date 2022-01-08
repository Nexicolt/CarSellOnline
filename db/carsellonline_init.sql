SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `carsellonline` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `carsellonline`;

CREATE TABLE `additional_dealer_data` (
  `Id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `company_name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `nip` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `regon` varchar(40) COLLATE utf8_polish_ci NOT NULL,
  `postal` varchar(7) COLLATE utf8_polish_ci NOT NULL,
  `street` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `city` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `phone` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `additional_dealer_data` (`Id`, `userId`, `company_name`, `nip`, `regon`, `postal`, `street`, `city`, `phone`) VALUES
(2, 23, 'Amazing Cars Sp. Z o. o.', '15156153561', '5156656', '33-300', 'Al. Józefa Piłsudskiego', 'Nowy Sącz', 588110235),
(3, 24, 'SamochodyCool SA', '925621265', '65165156165', '34-654', 'Pokątna', 'Limanowa', 332110554),
(4, 25, 'SprzedamCie Jerzy Szkaradek', '686256256', '6516515616589', '200-152', 'Powstańców', 'Warszawa', 458985458);

CREATE TABLE `advertisement` (
  `Id` int(11) NOT NULL,
  `Title` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `Description` text COLLATE utf8_polish_ci NOT NULL,
  `CreateBy` int(11) NOT NULL,
  `CreateDate` date NOT NULL,
  `Price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `advertisement` (`Id`, `Title`, `Description`, `CreateBy`, `CreateDate`, `Price`) VALUES
(36, 'Nówka sztuka, prosto z niemiec [OKAZJA]', '   Nowiutka mazda 3 z bardzo niskim przebiegiem. Druga taka okazja, długo się nie powtórzy. ', 23, '2022-01-04', '47569'),
(37, 'Astra G | Drugi właściciel | Sprowadzona', '  Przedstawiam państwu, leciwą, ale wciąż jara Astrę G, która na drodze, potrafi zawstydzane niejeden nowy wóz. Cena okazyjna, tylko do soboty. ', 23, '2022-01-04', '7420'),
(38, 'For Fiesta - spoko opcja', 'Sprzedam forda. Nie chce mi sie rozpisywać. Więcej info udzielam telefonicznie  ', 23, '2022-01-04', '32800'),
(39, 'BMW X5 [SERWIS ASO] [Pierwszy właaściciel]', 'Nowiutkie BMW. Dopiero co wzięta z leasingu. Serwisowane w ASo do końca. Można zrobić pomiar sprężania na cylindrach  ', 24, '2022-01-04', '159630'),
(40, 'Leon 3 | Salon Polska', 'Samochód z polskiego salonu. Zdjęcia później  ', 24, '2022-01-04', '12500'),
(41, 'Peugeot jak marzenie', 'Peugeot jak marzenia. Nie ma co pisac, Trzbea przyjechać i oglądnąć  ', 25, '2022-01-04', '111000');
DELIMITER $$
CREATE TRIGGER `AdvertisementAutoCreateDate` BEFORE INSERT ON `advertisement` FOR EACH ROW BEGIN
    SET NEW.CreateDate = NOW();
END
$$
DELIMITER ;

CREATE TABLE `advertisement_detail` (
  `Id` int(11) NOT NULL,
  `advertisementId` int(11) NOT NULL,
  `carBrandId` int(11) NOT NULL,
  `model` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `engine_size` float NOT NULL,
  `engine_power` float NOT NULL,
  `distance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `advertisement_detail` (`Id`, `advertisementId`, `carBrandId`, `model`, `engine_size`, `engine_power`, `distance`) VALUES
(33, 36, 40, '3', 1.7, 212, 124856),
(34, 37, 48, 'Astra G', 2, 105, 542000),
(35, 38, 21, 'Fiesta', 1.4, 82, 87500),
(36, 39, 6, 'X5', 2.9, 212, 100000),
(37, 40, 55, 'Leon 3', 2.2, 145, 320000),
(38, 41, 49, 'Traveller L2', 2.4, 189, 25000);

CREATE TABLE `carbrand` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `carbrand` (`Id`, `Name`) VALUES
(1, 'Abarth'),
(2, 'Alfa Romeo'),
(3, 'Aston Martin'),
(4, 'Audi'),
(5, 'Bentley'),
(6, 'BMW'),
(7, 'Bugatti'),
(8, 'Cadillac'),
(9, 'Chevrolet'),
(10, 'Chrysler'),
(11, 'Citroën'),
(12, 'Dacia'),
(13, 'Daewoo'),
(14, 'Daihatsu'),
(15, 'Dodge'),
(16, 'Donkervoort'),
(17, 'DS'),
(18, 'Ferrari'),
(19, 'Fiat'),
(20, 'Fisker'),
(21, 'Ford'),
(22, 'Honda'),
(23, 'Hummer'),
(24, 'Hyundai'),
(25, 'Infiniti'),
(26, 'Iveco'),
(27, 'Jaguar'),
(28, 'Jeep'),
(29, 'Kia'),
(30, 'KTM'),
(31, 'Lada'),
(32, 'Lamborghini'),
(33, 'Lancia'),
(34, 'Land Rover'),
(35, 'Landwind'),
(36, 'Lexus'),
(37, 'Lotus'),
(38, 'Maserati'),
(39, 'Maybach'),
(40, 'Mazda'),
(41, 'McLaren'),
(42, 'Mercedes-Benz'),
(43, 'MG'),
(44, 'Mini'),
(45, 'Mitsubishi'),
(46, 'Morgan'),
(47, 'Nissan'),
(48, 'Opel'),
(49, 'Peugeot'),
(50, 'Porsche'),
(51, 'Renault'),
(52, 'Rolls-Royce'),
(53, 'Rover'),
(54, 'Saab'),
(55, 'Seat'),
(56, 'Skoda'),
(57, 'Smart'),
(58, 'SsangYong'),
(59, 'Subaru'),
(60, 'Suzuki'),
(61, 'Tesla'),
(62, 'Toyota'),
(63, 'Volkswagen'),
(64, 'Volvo');

CREATE TABLE `comisrequest` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `comisrequest` (`Id`, `UserId`) VALUES
(20, 21),
(21, 22),
(25, 26);

CREATE TABLE `opinion` (
  `Id` int(11) NOT NULL,
  `dealerId` int(11) NOT NULL,
  `opinionAuthor` int(11) NOT NULL,
  `feeling` varchar(3) COLLATE utf8_polish_ci NOT NULL,
  `opinion` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `opinion` (`Id`, `dealerId`, `opinionAuthor`, `feeling`, `opinion`) VALUES
(2, 23, 26, 'OK', 'Spoko sprzedawca. Kupiłem fajny samochód');

CREATE TABLE `user` (
  `Id` int(11) NOT NULL,
  `Login` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `Type` char(1) COLLATE utf8_polish_ci NOT NULL,
  `Enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

INSERT INTO `user` (`Id`, `Login`, `Password`, `Email`, `Type`, `Enabled`) VALUES
(21, 'Admin', '$2y$10$x70i0UkFWS24pT/Dcc5.U.xEd82RVFuw0V43lsbOIb3K4JJ2oQ6Ie', 'admin@wp.pl', 'A', 1),
(22, 'SuperCar', '$2y$10$itUecrRNw5Uhhuk.nuhtb.6H1ObS4Pm3ksKOztm3ss/Y84wuYWaly', 'SuperCar@wp.pl', 'C', 0),
(23, 'AmazingCars', '$2y$10$0ZrKkvLcdKIX17G.eSRzCugyUcOGFLwVwuQ8bxJ5JpKxZpk15SV2W', 'AmazingCars@wp.pl', 'C', 1),
(24, 'SamochodyCool', '$2y$10$Ov8P6ek4/2A4EzPwMKg69.sTJ5su/tagtRZ3lNynMte7/xSUDaJt.', 'SamochodyCool@wp.pl', 'C', 1),
(25, 'SprzedamCie', '$2y$10$0EmFcMN48aYgFvynIEf3GeYPswtoEoFzbIZ2UO2U2q12ltUwphNm.', 'SprzedamCie@wp.pl', 'C', 1),
(26, 'NormalnyUser', '$2y$10$gE054CVJXsmB.ymbaOLYce5InBiKtYJR74slpGfMRPMrGA1Ah3Zfa', 'NormalnyUser@wp.pl', 'U', 1);
CREATE TABLE `vadvertisement` (
`Id` int(11)
,`advertisementId` int(11)
,`Title` varchar(100)
,`Description` text
,`Price` decimal(10,0)
,`brand` varchar(100)
,`model` varchar(50)
,`engine_size` float
,`engine_power` float
,`distance` int(11)
,`CreateBy` int(11)
,`CreateDate` date
);
CREATE TABLE `vdealerrequest` (
`ComisRequest` int(11)
,`Id` int(11)
,`userId` int(11)
,`company_name` varchar(255)
,`nip` varchar(40)
,`regon` varchar(40)
,`postal` varchar(7)
,`street` varchar(150)
,`city` varchar(150)
,`phone` int(12)
,`Email` varchar(255)
,`Login` varchar(255)
);
CREATE TABLE `vopinion` (
`dealerId` int(11)
,`opinion` text
,`feeling` varchar(3)
,`CreateBy` varchar(255)
);
CREATE TABLE `vseller` (
`Id` int(11)
,`company_name` varchar(255)
,`email` varchar(255)
,`phone` int(12)
);
DROP TABLE IF EXISTS `vadvertisement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vadvertisement`  AS SELECT `a`.`Id` AS `Id`, `ad`.`advertisementId` AS `advertisementId`, `a`.`Title` AS `Title`, `a`.`Description` AS `Description`, `a`.`Price` AS `Price`, `c`.`Name` AS `brand`, `ad`.`model` AS `model`, `ad`.`engine_size` AS `engine_size`, `ad`.`engine_power` AS `engine_power`, `ad`.`distance` AS `distance`, `a`.`CreateBy` AS `CreateBy`, `a`.`CreateDate` AS `CreateDate` FROM ((`advertisement` `a` join `advertisement_detail` `ad` on(`a`.`Id` = `ad`.`advertisementId`)) join `carbrand` `c` on(`ad`.`carBrandId` = `c`.`Id`)) ;
DROP TABLE IF EXISTS `vdealerrequest`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vdealerrequest`  AS SELECT `c`.`Id` AS `ComisRequest`, `ad`.`Id` AS `Id`, `ad`.`userId` AS `userId`, `ad`.`company_name` AS `company_name`, `ad`.`nip` AS `nip`, `ad`.`regon` AS `regon`, `ad`.`postal` AS `postal`, `ad`.`street` AS `street`, `ad`.`city` AS `city`, `ad`.`phone` AS `phone`, `u`.`Email` AS `Email`, `u`.`Login` AS `Login` FROM ((`additional_dealer_data` `ad` join `comisrequest` `c` on(`ad`.`userId` = `c`.`UserId`)) join `user` `u` on(`u`.`Id` = `ad`.`userId`)) ;
DROP TABLE IF EXISTS `vopinion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vopinion`  AS SELECT `o`.`dealerId` AS `dealerId`, `o`.`opinion` AS `opinion`, `o`.`feeling` AS `feeling`, `u`.`Login` AS `CreateBy` FROM (`opinion` `o` join `user` `u` on(`o`.`opinionAuthor` = `u`.`Id`)) ;
DROP TABLE IF EXISTS `vseller`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vseller`  AS SELECT `a2`.`Id` AS `Id`, `a`.`company_name` AS `company_name`, `u`.`Email` AS `email`, `a`.`phone` AS `phone` FROM ((`user` `u` join `additional_dealer_data` `a` on(`u`.`Id` = `a`.`userId`)) join `advertisement` `a2` on(`u`.`Id` = `a2`.`CreateBy`)) WHERE `u`.`Type` = 'C' ;


ALTER TABLE `additional_dealer_data`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_grade_id` (`userId`);

ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CreateBy` (`CreateBy`) USING BTREE;

ALTER TABLE `advertisement_detail`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `carBrandId` (`carBrandId`),
  ADD KEY `advertisementId` (`advertisementId`);

ALTER TABLE `carbrand`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `comisrequest`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`);

ALTER TABLE `opinion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `dealerId` (`dealerId`),
  ADD KEY `opinionAuthor` (`opinionAuthor`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`Id`);


ALTER TABLE `additional_dealer_data`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `advertisement`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

ALTER TABLE `advertisement_detail`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

ALTER TABLE `carbrand`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

ALTER TABLE `comisrequest`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `opinion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `user`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;


ALTER TABLE `additional_dealer_data`
  ADD CONSTRAINT `fk_grade_id` FOREIGN KEY (`userId`) REFERENCES `user` (`Id`);

ALTER TABLE `advertisement`
  ADD CONSTRAINT `advertisement_ibfk_1` FOREIGN KEY (`CreateBy`) REFERENCES `user` (`Id`);

ALTER TABLE `advertisement_detail`
  ADD CONSTRAINT `advertisement_detail_ibfk_1` FOREIGN KEY (`carBrandId`) REFERENCES `carbrand` (`Id`),
  ADD CONSTRAINT `advertisement_detail_ibfk_2` FOREIGN KEY (`advertisementId`) REFERENCES `advertisement` (`Id`);

ALTER TABLE `comisrequest`
  ADD CONSTRAINT `comisrequest_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `user` (`Id`);

ALTER TABLE `opinion`
  ADD CONSTRAINT `opinion_ibfk_1` FOREIGN KEY (`dealerId`) REFERENCES `user` (`Id`),
  ADD CONSTRAINT `opinion_ibfk_2` FOREIGN KEY (`opinionAuthor`) REFERENCES `user` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
