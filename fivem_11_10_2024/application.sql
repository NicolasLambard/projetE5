-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 12 déc. 2024 à 10:08
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Structure de la table `APP_chat_box_logs`
--

CREATE TABLE `APP_chat_box_logs` (
  `id_chatbox` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `id_demande` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
(1, 'en cours'),
(2, 'Fini'),
(3, 'test');

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
-- Index pour la table `APP_chat_box_logs`
--
ALTER TABLE `APP_chat_box_logs`
  ADD PRIMARY KEY (`id_chatbox`),
  ADD KEY `APP_chat_box_logs_APP_demandes_FK` (`id_demande`),
  ADD KEY `APP_chat_box_logs_APP_users0_FK` (`id`);

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


-- Index pour la table `APP_fichiers`
--
ALTER TABLE `APP_fichiers`
  ADD PRIMARY KEY (`id_fichier`),
  ADD KEY `APP_fichiers_APP_demandes_FK` (`id_demande`);

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

-- AUTO_INCREMENT pour la table `APP_chat_box_logs`
--
ALTER TABLE `APP_chat_box_logs`
  MODIFY `id_chatbox` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `APP_commentaires`
--
ALTER TABLE `APP_commentaires`
  MODIFY `id_commentaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `APP_demandes`
--
ALTER TABLE `APP_demandes`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;


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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `APP_chat_box_logs`
--
ALTER TABLE `APP_chat_box_logs`
  ADD CONSTRAINT `APP_chat_box_logs_APP_demandes_FK` FOREIGN KEY (`id_demande`) REFERENCES `APP_demandes` (`id_demande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `APP_chat_box_logs_APP_users0_FK` FOREIGN KEY (`id`) REFERENCES `APP_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
