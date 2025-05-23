-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 23 mai 2025 à 11:59
-- Version du serveur : 10.11.11-MariaDB-0+deb12u1
-- Version de PHP : 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lambardn_avril`
--

-- --------------------------------------------------------

--
-- Structure de la table `APP_commentaires`
--

CREATE TABLE `APP_commentaires` (
  `id_commentaire` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `id_demande` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `APP_commentaires`
--

INSERT INTO `APP_commentaires` (`id_commentaire`, `description`, `date`, `valide`, `id_demande`, `id`) VALUES
(15, 'test', '2025-05-23 09:26:36', 1, 40, 21),
(16, 'Merci', '2025-05-23 09:27:20', 1, 40, 14);

-- --------------------------------------------------------

--
-- Structure de la table `APP_demandes`
--

CREATE TABLE `APP_demandes` (
  `id_demande` int(11) NOT NULL,
  `description_demande` varchar(255) NOT NULL,
  `date_commande` datetime NOT NULL,
  `description_resultat` varchar(255) NOT NULL,
  `date_resultat` datetime NOT NULL,
  `prix` decimal(16,6) NOT NULL,
  `date_travail` datetime NOT NULL,
  `id` int(11) NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `APP_demandes`
--

INSERT INTO `APP_demandes` (`id_demande`, `description_demande`, `date_commande`, `description_resultat`, `date_resultat`, `prix`, `date_travail`, `id`, `id_status`) VALUES
(39, 'test', '2025-05-23 09:22:09', 'Création d\'un script complet sur mesure selon les besoins du client', '2025-07-10 00:00:00', 200.000000, '2025-05-23 09:22:09', 20, 1),
(40, 'aaaaaaa', '2025-05-23 09:24:49', 'Débogage de script', '2025-06-23 00:00:00', 20.000000, '2025-05-23 09:24:49', 21, 2);

-- --------------------------------------------------------

--
-- Structure de la table `APP_fichiers`
--

CREATE TABLE `APP_fichiers` (
  `id_fichier` int(11) NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `commentaire_fichier` varchar(255) NOT NULL,
  `date_depot` datetime NOT NULL,
  `auteur_client` tinyint(1) NOT NULL,
  `id_demande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `APP_roles`
--

CREATE TABLE `APP_roles` (
  `id_role` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `APP_roles`
--

INSERT INTO `APP_roles` (`id_role`, `nom`) VALUES
(1, 'superadmin'),
(2, 'gestionnaire'),
(3, 'client');

-- --------------------------------------------------------

--
-- Structure de la table `APP_services`
--

CREATE TABLE `APP_services` (
  `id_service` int(11) NOT NULL,
  `nom_service` varchar(255) NOT NULL,
  `description_service` varchar(255) NOT NULL,
  `prix` decimal(16,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `APP_services`
--

INSERT INTO `APP_services` (`id_service`, `nom_service`, `description_service`, `prix`) VALUES
(1, 'Création d\'un environnement sur mesure (BDD,Panel admin , Base jeu)', 'Conception\r\nd\'une base adaptée aux besoins spécifiques du client.\r\n', 50.000000),
(2, 'Création d\'un script complet sur mesure selon les besoins du client', 'Sélection du\r\nframework : ESX-Legacy [FiveM] – Dernière version', 80.000000),
(3, 'Débogage de script', 'Analyse et correction du script pour résoudre\r\nles erreurs et améliorer la performance', 20.000000);

-- --------------------------------------------------------

--
-- Structure de la table `APP_services_demandes`
--

CREATE TABLE `APP_services_demandes` (
  `id_service` int(11) NOT NULL,
  `id_demande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `APP_statuts`
--

CREATE TABLE `APP_statuts` (
  `id_status` int(11) NOT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `APP_statuts`
--

INSERT INTO `APP_statuts` (`id_status`, `label`) VALUES
(1, 'En cours'),
(2, 'Terminé');

-- --------------------------------------------------------

--
-- Structure de la table `APP_suivis`
--

CREATE TABLE `APP_suivis` (
  `id_suivi` int(11) NOT NULL,
  `status_commande` varchar(50) NOT NULL,
  `date_suivi` datetime NOT NULL,
  `message` varchar(1000) NOT NULL,
  `auteur_client` tinyint(1) NOT NULL,
  `id_demande` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `id_service_APP_services_demandes` int(11) DEFAULT NULL,
  `id_demande_APP_services_demandes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `APP_users`
--

CREATE TABLE `APP_users` (
  `id` int(11) NOT NULL,
  `nom` varchar(35) NOT NULL,
  `prenom` varchar(35) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `telephone` varchar(60) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `APP_users`
--

INSERT INTO `APP_users` (`id`, `nom`, `prenom`, `email`, `email_verified_at`, `telephone`, `name`, `password`, `remember_token`, `create_at`, `update_at`, `id_role`) VALUES
(13, 'superadmin', 'superadmin', 'superadmin@gmail.com', '2025-05-23 09:25:42', '0621459865', 'superadmin', '$2y$12$AIN/nV/pCRtX/ngeYEfYxu05o1X1Ou.G4LYLFrAKvDYd0fj7VVBou', 'YTFMXwO8tODVqb29qeoPakV9VX9MDvzkXNXwAuuEL9uQB66CCQKCnr5q97Ai', '2024-12-13 11:12:36', '2024-12-13 11:12:36', 1),
(14, 'Gestionnaire', 'Gestionnaire', 'gestionnaire@gmail.com', '2025-05-23 09:21:39', '0632145896', 'Gestionnaire', '$2y$12$MPOPpyqACpyMnGgQn93niuSE7sR2c6PSCCqP6JV/hWSTMorQU3xOe', '7Q3n41eolyKIYhxd9nJiqpzKkRnc1oK8nJtDlYnGx7peov9vmfaPK0Blv9FX', '2024-12-13 11:14:12', '2024-12-13 11:14:12', 2),
(20, 'Nicolas', 'Lambard', 'nicolas@gmail.com', '2025-05-23 09:22:51', '0678479874', 'Nicoo', '$2y$12$.CHAu.YAJm09YeN2qJ0snOBw75k3ZbXRK.xiAZMrFHgVioQs9MYAC', '50kyjHd1eCeyQL49CfFSDYVLjSoEwLS2GFl3n0qNrmYe2zscswOZN4fOzSaJ', '2025-05-23 07:20:27', '2025-05-23 07:20:27', 3),
(21, 'tom', 'Durant', 'tom@gmail.com', '2025-05-23 09:26:06', 'Durant', 'Tom', '$2y$12$ilkykXhShjRVzVxx7IcE2e2ula1C68uEC1eJ/TdmJTENepCBAhrgy', 'GVxphf319bwUPljzGHcoVKNZy2SFsRiLpuAMdcv3XKxlBmmvohovadX7dAb9', '2025-05-23 07:23:25', '2025-05-23 07:23:25', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `APP_commentaires`
--
ALTER TABLE `APP_commentaires`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `APP_commentaires_APP_demandes_FK` (`id_demande`),
  ADD KEY `APP_commentaires_APP_users0_FK` (`id`);

--
-- Index pour la table `APP_demandes`
--
ALTER TABLE `APP_demandes`
  ADD PRIMARY KEY (`id_demande`),
  ADD KEY `APP_demandes_APP_users_FK` (`id`),
  ADD KEY `APP_demandes_APP_statuts0_FK` (`id_status`);

--
-- Index pour la table `APP_fichiers`
--
ALTER TABLE `APP_fichiers`
  ADD PRIMARY KEY (`id_fichier`),
  ADD KEY `APP_fichiers_APP_demandes_FK` (`id_demande`);

--
-- Index pour la table `APP_roles`
--
ALTER TABLE `APP_roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `APP_services`
--
ALTER TABLE `APP_services`
  ADD PRIMARY KEY (`id_service`);

--
-- Index pour la table `APP_services_demandes`
--
ALTER TABLE `APP_services_demandes`
  ADD PRIMARY KEY (`id_service`,`id_demande`),
  ADD KEY `APP_services_demandes_APP_demandes0_FK` (`id_demande`);

--
-- Index pour la table `APP_statuts`
--
ALTER TABLE `APP_statuts`
  ADD PRIMARY KEY (`id_status`);

--
-- Index pour la table `APP_suivis`
--
ALTER TABLE `APP_suivis`
  ADD PRIMARY KEY (`id_suivi`),
  ADD KEY `APP_suivis_APP_demandes_FK` (`id_demande`),
  ADD KEY `APP_suivis_APP_statuts0_FK` (`id_status`),
  ADD KEY `APP_suivis_APP_services_demandes1_FK` (`id_service_APP_services_demandes`,`id_demande_APP_services_demandes`);

--
-- Index pour la table `APP_users`
--
ALTER TABLE `APP_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `APP_users_APP_roles_FK` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `APP_commentaires`
--
ALTER TABLE `APP_commentaires`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `APP_demandes`
--
ALTER TABLE `APP_demandes`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `APP_fichiers`
--
ALTER TABLE `APP_fichiers`
  MODIFY `id_fichier` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `APP_roles`
--
ALTER TABLE `APP_roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `APP_services`
--
ALTER TABLE `APP_services`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `APP_statuts`
--
ALTER TABLE `APP_statuts`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `APP_suivis`
--
ALTER TABLE `APP_suivis`
  MODIFY `id_suivi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `APP_users`
--
ALTER TABLE `APP_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `APP_commentaires`
--
ALTER TABLE `APP_commentaires`
  ADD CONSTRAINT `APP_commentaires_APP_demandes_FK` FOREIGN KEY (`id_demande`) REFERENCES `APP_demandes` (`id_demande`),
  ADD CONSTRAINT `APP_commentaires_APP_users0_FK` FOREIGN KEY (`id`) REFERENCES `APP_users` (`id`);

--
-- Contraintes pour la table `APP_demandes`
--
ALTER TABLE `APP_demandes`
  ADD CONSTRAINT `APP_demandes_APP_statuts0_FK` FOREIGN KEY (`id_status`) REFERENCES `APP_statuts` (`id_status`),
  ADD CONSTRAINT `APP_demandes_APP_users_FK` FOREIGN KEY (`id`) REFERENCES `APP_users` (`id`);

--
-- Contraintes pour la table `APP_fichiers`
--
ALTER TABLE `APP_fichiers`
  ADD CONSTRAINT `APP_fichiers_APP_demandes_FK` FOREIGN KEY (`id_demande`) REFERENCES `APP_demandes` (`id_demande`);

--
-- Contraintes pour la table `APP_services_demandes`
--
ALTER TABLE `APP_services_demandes`
  ADD CONSTRAINT `APP_services_demandes_APP_demandes0_FK` FOREIGN KEY (`id_demande`) REFERENCES `APP_demandes` (`id_demande`),
  ADD CONSTRAINT `APP_services_demandes_APP_services_FK` FOREIGN KEY (`id_service`) REFERENCES `APP_services` (`id_service`);

--
-- Contraintes pour la table `APP_suivis`
--
ALTER TABLE `APP_suivis`
  ADD CONSTRAINT `APP_suivis_APP_demandes_FK` FOREIGN KEY (`id_demande`) REFERENCES `APP_demandes` (`id_demande`),
  ADD CONSTRAINT `APP_suivis_APP_services_demandes1_FK` FOREIGN KEY (`id_service_APP_services_demandes`,`id_demande_APP_services_demandes`) REFERENCES `APP_services_demandes` (`id_service`, `id_demande`),
  ADD CONSTRAINT `APP_suivis_APP_statuts0_FK` FOREIGN KEY (`id_status`) REFERENCES `APP_statuts` (`id_status`);

--
-- Contraintes pour la table `APP_users`
--
ALTER TABLE `APP_users`
  ADD CONSTRAINT `APP_users_APP_roles_FK` FOREIGN KEY (`id_role`) REFERENCES `APP_roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
