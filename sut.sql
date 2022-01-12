-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2022 at 11:48 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sut`
--

-- --------------------------------------------------------

--
-- Table structure for table `etudianttuteur`
--

CREATE TABLE `etudianttuteur` (
  `id_etudiant` int(11) DEFAULT NULL,
  `id_tuteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `etudianttuteur`
--

INSERT INTO `etudianttuteur` (`id_etudiant`, `id_tuteur`) VALUES
(110, 115);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `id_tuteur` int(11) DEFAULT NULL,
  `id_etudiant` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start`, `end`, `id_tuteur`, `id_etudiant`) VALUES
(424, 'RDV avec tuteur Maths', '2022-01-13 09:00:00', '2022-01-13 11:00:00', NULL, 110),
(426, '! PARTIEL ! ', '2022-02-08 00:00:00', '2022-02-09 00:00:00', NULL, 110),
(427, '! INTERRO !', '2022-01-21 10:00:00', '2022-01-21 12:00:00', NULL, 110),
(428, 'Quiz WEB', '2022-01-18 03:00:00', '2022-01-18 04:00:00', NULL, 110);

-- --------------------------------------------------------

--
-- Table structure for table `review_table`
--

CREATE TABLE `review_table` (
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_rating` int(11) NOT NULL,
  `user_review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_table`
--

INSERT INTO `review_table` (`review_id`, `user_name`, `user_rating`, `user_review`, `datetime`, `id_utilisateur`) VALUES
(54, 'User', 4, 'Très bien!!!', '2022-01-12 10:13:46', 115),
(55, 'a', 3, 'a', '2022-01-12 11:44:42', 115);

-- --------------------------------------------------------

--
-- Table structure for table `ue`
--

CREATE TABLE `ue` (
  `id_ue` int(11) NOT NULL,
  `nom_ue` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ue`
--

INSERT INTO `ue` (`id_ue`, `nom_ue`) VALUES
(0, 'Mathématiques Discrètes'),
(1, 'Programmation fonctionnelle'),
(2, 'WEB');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mdp` varchar(20) DEFAULT NULL,
  `user_activation_code` varchar(250) NOT NULL,
  `user_email_status` enum('not verified','verified') NOT NULL,
  `roles` enum('E','T') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `prenom`, `email`, `mdp`, `user_activation_code`, `user_email_status`, `roles`) VALUES
(110, 'Utilisateur', 'User', 'user@gmail.com', 'aaaaaA1!', 'bec71df44d4e3103f91046ffa0a6ea39', 'verified', 'E'),
(115, 'Doe', 'Jane', 'email@gmail.com', 'aaaaaA1!', '0123456789', 'verified', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurue`
--

CREATE TABLE `utilisateurue` (
  `id_ue` int(11) DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurue`
--

INSERT INTO `utilisateurue` (`id_ue`, `id_utilisateur`) VALUES
(0, 115),
(0, 110);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etudianttuteur`
--
ALTER TABLE `etudianttuteur`
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_tuteur` (`id_tuteur`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tuteur` (`id_tuteur`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Indexes for table `review_table`
--
ALTER TABLE `review_table`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `ue`
--
ALTER TABLE `ue`
  ADD PRIMARY KEY (`id_ue`),
  ADD UNIQUE KEY `id_ue` (`id_ue`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `utilisateurue`
--
ALTER TABLE `utilisateurue`
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_ue` (`id_ue`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=440;

--
-- AUTO_INCREMENT for table `review_table`
--
ALTER TABLE `review_table`
  MODIFY `review_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `etudianttuteur`
--
ALTER TABLE `etudianttuteur`
  ADD CONSTRAINT `EtudiantTuteur_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `EtudiantTuteur_ibfk_2` FOREIGN KEY (`id_tuteur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`id_tuteur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Constraints for table `review_table`
--
ALTER TABLE `review_table`
  ADD CONSTRAINT `review_table_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Constraints for table `utilisateurue`
--
ALTER TABLE `utilisateurue`
  ADD CONSTRAINT `UtilisateurUe_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `UtilisateurUe_ibfk_2` FOREIGN KEY (`id_ue`) REFERENCES `ue` (`id_ue`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
