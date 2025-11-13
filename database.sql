-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 nov. 2025 à 22:08
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `netvod`
--

-- --------------------------------------------------------

--
-- Structure de la table `avisserie`
--

CREATE TABLE `avisserie` (
  `user_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `note` decimal(2,1) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avisserie`
--

INSERT INTO `avisserie` (`user_id`, `serie_id`, `note`, `commentaire`, `date_creation`) VALUES
(1, 1, '5.0', 'Trop bien', '2025-11-12 16:35:41'),
(1, 2, '3.0', 'Pas ouf la série en vrai', '2025-11-12 16:36:28');

-- --------------------------------------------------------

--
-- Structure de la table `avisvideo`
--

CREATE TABLE `avisvideo` (
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `note` decimal(2,1) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `lib_genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`genre_id`, `lib_genre`) VALUES
(1, 'Action'),
(2, 'Comédie'),
(3, 'Drame'),
(4, 'Science-Fiction'),
(5, 'Documentaire'),
(6, 'Fantastique');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `profil_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `genre_pref` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`profil_id`, `user_id`, `prenom`, `nom`, `genre_pref`) VALUES
(1, 1, 'Hugo', 'Antzorn', 'Horreur'),
(2, 1, 'Walid', 'Bouaoukel', 'Western'),
(3, 1, 'Walid', 'Bouaoukel', 'Western'),
(4, 1, 'Walid', 'Bouaoukel', 'Western'),
(5, 1, 'Walid', 'Bouaoukel', 'Western'),
(6, 2, 'Hugo', 'User', 'Comédie');

-- --------------------------------------------------------

--
-- Structure de la table `publiccible`
--

CREATE TABLE `publiccible` (
  `public_id` int(11) NOT NULL,
  `lib_public` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `publiccible`
--

INSERT INTO `publiccible` (`public_id`, `lib_public`) VALUES
(1, 'Tout public'),
(2, 'Adolescent'),
(3, 'Adulte');

-- --------------------------------------------------------

--
-- Structure de la table `saison`
--

CREATE TABLE `saison` (
  `saison_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `num_saison` int(11) NOT NULL,
  `titre_saison` varchar(255) DEFAULT NULL,
  `descriptif` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `saison`
--

INSERT INTO `saison` (`saison_id`, `serie_id`, `num_saison`, `titre_saison`, `descriptif`) VALUES
(1, 1, 1, 'Saison 1', 'Premiers voyages temporels.'),
(2, 2, 1, 'Saison 1', 'Les débuts de la colocation.'),
(3, 3, 1, 'Saison 1', 'Histoires d’amour et de séparation.'),
(4, 4, 1, 'Saison 1', 'Découverte d’un nouveau système stellaire.'),
(5, 5, 1, 'Saison 1', 'Exploration des écosystèmes terrestres.');

-- --------------------------------------------------------

--
-- Structure de la table `serie`
--

CREATE TABLE `serie` (
  `serie_id` int(11) NOT NULL,
  `nom_serie` varchar(255) NOT NULL,
  `resume` text DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `date_ajout` datetime DEFAULT current_timestamp(),
  `chemin_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `serie`
--

INSERT INTO `serie` (`serie_id`, `nom_serie`, `resume`, `date_sortie`, `date_ajout`, `chemin_image`) VALUES
(1, 'Les Voyageurs du Temps', 'Une équipe explore différentes époques.', '2020-03-15', '2020-03-20 00:00:00', 'images/cars-by-night.png'),
(2, 'Rires en Folie', 'Une sitcom hilarante sur la colocation.', '2021-01-10', '2021-01-12 00:00:00', 'images/lake.png'),
(3, 'Cœurs Brisés', 'Une série romantique dramatique.', '2022-06-05', '2022-06-10 00:00:00', 'images/beach.png'),
(4, 'Au-delà des Étoiles', 'Exploration spatiale et mystères interstellaires.', '2023-09-22', '2023-09-25 00:00:00', 'images/water.png'),
(5, 'Les Secrets de la Terre', 'Découverte des merveilles naturelles du monde.', '2019-05-30', '2019-06-01 00:00:00', 'images/poney.png');

-- --------------------------------------------------------

--
-- Structure de la table `serie2genre`
--

CREATE TABLE `serie2genre` (
  `serie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `serie2genre`
--

INSERT INTO `serie2genre` (`serie_id`, `genre_id`) VALUES
(1, 4),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `userlistserie`
--

CREATE TABLE `userlistserie` (
  `profil_id` int(11) NOT NULL,
  `serie_id` int(11) NOT NULL,
  `type_liste` varchar(50) NOT NULL,
  `position_courante` int(11) DEFAULT NULL,
  `date_maj` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `userlistserie`
--

INSERT INTO `userlistserie` (`profil_id`, `serie_id`, `type_liste`, `position_courante`, `date_maj`) VALUES
(1, 1, 'dejaVisionnees', 2, '2025-11-13 21:41:21');

-- --------------------------------------------------------

--
-- Structure de la table `userlistvideo`
--

CREATE TABLE `userlistvideo` (
  `profil_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `type_liste` varchar(50) NOT NULL,
  `position_courante` int(11) DEFAULT NULL,
  `date_maj` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp(),
  `carte_num` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `activation_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`user_id`, `email`, `password`, `date_creation`, `carte_num`, `is_active`, `activation_token`) VALUES
(1, 'nickben1254@gmail.com', '$2y$10$5xUOnS7OB31IT/jxticYXuL.0rFMTTNF22YtAB9ozYFf95ht2pDOa', '2025-11-12 13:26:42', NULL, 1, NULL),
(2, 'user1@mail.com', '$2y$10$EN0X0mWHpdnp2uQ5U2cmZ.NmStDeEiB9YlSyBjYNaQVrQSzAuZc6G', '2025-11-13 21:53:28', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `video_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `resume` text DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `type_video` varchar(50) DEFAULT NULL,
  `annee_sortie` year(4) DEFAULT NULL,
  `date_ajout` datetime DEFAULT current_timestamp(),
  `saison_id` int(11) DEFAULT NULL,
  `num_dans_saison` int(11) DEFAULT NULL,
  `chemin_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`video_id`, `titre`, `resume`, `duree`, `fichier`, `type_video`, `annee_sortie`, `date_ajout`, `saison_id`, `num_dans_saison`, `chemin_image`) VALUES
(1, 'Le portail temporel', 'Découverte du portail du temps.', 45, 'video/cars-by-night.mp4', 'episode', 2020, '2020-03-21 00:00:00', 1, 1, 'images/cars-by-night.png'),
(2, 'Retour au futur ancien', 'Les premiers effets du voyage temporel.', 47, 'video/dramatic.mp4', 'episode', 2020, '2020-03-22 00:00:00', 1, 2, 'images/dramatic.png'),
(3, 'Nouvelle colocation', 'Les colocs s’installent ensemble.', 25, 'video/funes.mp4', 'episode', 2021, '2021-01-13 00:00:00', 2, 1, 'images/funes.png'),
(4, 'Soirée catastrophe', 'Un dîner qui tourne au désastre.', 24, 'video/rubbit.mp4', 'episode', 2021, '2021-01-14 00:00:00', 2, 2, 'images/rubbit.png'),
(5, 'Rencontre', 'Deux âmes se croisent par hasard.', 42, 'video/faceplant.mp4', 'episode', 2022, '2022-06-11 00:00:00', 3, 1, 'images/faceplant.png'),
(6, 'Séparation', 'La distance met leur amour à l’épreuve.', 44, 'video/zoo.mp4', 'episode', 2022, '2022-06-12 00:00:00', 3, 2, 'images/zoo.png'),
(7, 'Décollage', 'Premier voyage vers Proxima Centauri.', 50, 'video/surf.mp4', 'episode', 2023, '2023-09-26 00:00:00', 4, 1, 'images/surf.png'),
(8, 'Rencontre Alien', 'Premier contact extraterrestre.', 52, 'video/beach.mp4', 'episode', 2023, '2023-09-27 00:00:00', 4, 2, 'images/beach.png'),
(9, 'Les profondeurs de l’océan', 'Exploration de la vie marine.', 48, 'video/horses.mp4', 'episode', 2019, '2019-06-02 00:00:00', 5, 1, 'images/poney.png'),
(10, 'Les déserts vivants', 'La vie dans les zones arides.', 46, 'video/lake.mp4', 'episode', 2019, '2019-06-03 00:00:00', 5, 2, 'images/lake.png'),
(11, 'Les volcans du monde', 'Ici les volcans', 20, 'video/minecraft.mp4', 'episode', 2010, '2025-11-12 12:57:52', 5, 3, 'images/minecraft.png');

-- --------------------------------------------------------

--
-- Structure de la table `video2genre`
--

CREATE TABLE `video2genre` (
  `video_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `video2genre`
--

INSERT INTO `video2genre` (`video_id`, `genre_id`) VALUES
(1, 4),
(2, 4),
(3, 2),
(4, 2),
(5, 3),
(6, 3),
(7, 4),
(8, 4),
(9, 5),
(10, 5);

-- --------------------------------------------------------

--
-- Structure de la table `video2public`
--

CREATE TABLE `video2public` (
  `video_id` int(11) NOT NULL,
  `public_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `video2public`
--

INSERT INTO `video2public` (`video_id`, `public_id`) VALUES
(1, 2),
(2, 2),
(3, 1),
(4, 1),
(5, 3),
(6, 3),
(7, 2),
(8, 2),
(9, 1),
(10, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avisserie`
--
ALTER TABLE `avisserie`
  ADD PRIMARY KEY (`user_id`,`serie_id`),
  ADD KEY `serie_id` (`serie_id`);

--
-- Index pour la table `avisvideo`
--
ALTER TABLE `avisvideo`
  ADD PRIMARY KEY (`user_id`,`video_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`profil_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `publiccible`
--
ALTER TABLE `publiccible`
  ADD PRIMARY KEY (`public_id`);

--
-- Index pour la table `saison`
--
ALTER TABLE `saison`
  ADD PRIMARY KEY (`saison_id`),
  ADD KEY `serie_id` (`serie_id`);

--
-- Index pour la table `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`serie_id`);

--
-- Index pour la table `serie2genre`
--
ALTER TABLE `serie2genre`
  ADD PRIMARY KEY (`serie_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Index pour la table `userlistserie`
--
ALTER TABLE `userlistserie`
  ADD PRIMARY KEY (`profil_id`,`serie_id`,`type_liste`),
  ADD KEY `serie_id` (`serie_id`);

--
-- Index pour la table `userlistvideo`
--
ALTER TABLE `userlistvideo`
  ADD PRIMARY KEY (`profil_id`,`video_id`,`type_liste`),
  ADD KEY `video_id` (`video_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `saison_id` (`saison_id`);

--
-- Index pour la table `video2genre`
--
ALTER TABLE `video2genre`
  ADD PRIMARY KEY (`video_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Index pour la table `video2public`
--
ALTER TABLE `video2public`
  ADD PRIMARY KEY (`video_id`,`public_id`),
  ADD KEY `public_id` (`public_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `profil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `publiccible`
--
ALTER TABLE `publiccible`
  MODIFY `public_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `saison`
--
ALTER TABLE `saison`
  MODIFY `saison_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `serie`
--
ALTER TABLE `serie`
  MODIFY `serie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avisserie`
--
ALTER TABLE `avisserie`
  ADD CONSTRAINT `avisserie_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`user_id`),
  ADD CONSTRAINT `avisserie_ibfk_2` FOREIGN KEY (`serie_id`) REFERENCES `serie` (`serie_id`);

--
-- Contraintes pour la table `avisvideo`
--
ALTER TABLE `avisvideo`
  ADD CONSTRAINT `avisvideo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`user_id`),
  ADD CONSTRAINT `avisvideo_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`);

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`user_id`);

--
-- Contraintes pour la table `saison`
--
ALTER TABLE `saison`
  ADD CONSTRAINT `saison_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `serie` (`serie_id`);

--
-- Contraintes pour la table `serie2genre`
--
ALTER TABLE `serie2genre`
  ADD CONSTRAINT `serie2genre_ibfk_1` FOREIGN KEY (`serie_id`) REFERENCES `serie` (`serie_id`),
  ADD CONSTRAINT `serie2genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`);

--
-- Contraintes pour la table `userlistserie`
--
ALTER TABLE `userlistserie`
  ADD CONSTRAINT `userlistserie_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profil` (`profil_id`),
  ADD CONSTRAINT `userlistserie_ibfk_2` FOREIGN KEY (`serie_id`) REFERENCES `serie` (`serie_id`);

--
-- Contraintes pour la table `userlistvideo`
--
ALTER TABLE `userlistvideo`
  ADD CONSTRAINT `userlistvideo_ibfk_1` FOREIGN KEY (`profil_id`) REFERENCES `profil` (`profil_id`),
  ADD CONSTRAINT `userlistvideo_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`saison_id`) REFERENCES `saison` (`saison_id`);

--
-- Contraintes pour la table `video2genre`
--
ALTER TABLE `video2genre`
  ADD CONSTRAINT `video2genre_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
  ADD CONSTRAINT `video2genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`);

--
-- Contraintes pour la table `video2public`
--
ALTER TABLE `video2public`
  ADD CONSTRAINT `video2public_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `video` (`video_id`),
  ADD CONSTRAINT `video2public_ibfk_2` FOREIGN KEY (`public_id`) REFERENCES `publiccible` (`public_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
