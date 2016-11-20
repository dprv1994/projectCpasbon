-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Dim 20 Novembre 2016 à 18:56
-- Version du serveur :  5.5.52-MariaDB
-- Version de PHP :  5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cpasbon`
--
CREATE DATABASE IF NOT EXISTS `cpasbon` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cpasbon`;

-- --------------------------------------------------------

--
-- Structure de la table `contact_information`
--

CREATE TABLE `contact_information` (
  `id` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `contact_information`
--

INSERT INTO `contact_information` (`id`, `data`, `value`) VALUES
(2, 'resto_name', 'Cpasbon'),
(3, 'adress', '74 avenue du mauvais goût'),
(4, 'zipcode', '33130'),
(5, 'city', 'Bordeaux'),
(6, 'phone', '0606060606'),
(10, 'slide_10', 'Jolie mais pourri,C\'est pas parce que le cadre est jolie et le plat apetissent que sa va pas finir aux chiotte !,img/pic_5831c07774a13.jpg'),
(11, 'slide_11', 'La café c\'est la clé du pognon,sur un café le benef est enorme ! et pourtant j\'en connais des choses qui ressemble d\'aspect et qui coute moins cheres,img/pic_5831c358b0d30.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `read_msg` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `subject`, `content`, `email`, `username`, `read_msg`) VALUES
(1, 'C\'était très très bon', 'Votre plat dégueulasse m\'a réglé l\'estomac, huum il est passé une fois puis une autre fois pour ressortir directement dans mes toilettes, un vrai régale !', 'Gvomi@gmail.com', 'EstomacDehors', 0),
(2, 'mon avis', 'Bonjour, voici mon avis sur votre restautant', 'symezac.valerie@neuf.fr', 'Valerie', 0),
(3, 'mon avis', 'Mon avis sur ce restaurant ! :-)', 'pierre@dupont.fr', 'pierre dupont', 1),
(4, 'mon avis', 'Mon avis très intéressant', 'valerie@neuf.fr', 'Valerie', 0);

-- --------------------------------------------------------

--
-- Structure de la table `recipe`
--

CREATE TABLE `recipe` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `ingredient` varchar(255) NOT NULL,
  `preparation` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `category` enum('Entrée','Plat','Dessert') NOT NULL,
  `url_img` varchar(255) NOT NULL,
  `id_autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `recipe`
--

INSERT INTO `recipe` (`id`, `title`, `ingredient`, `preparation`, `date_creation`, `category`, `url_img`, `id_autor`) VALUES
(2, 'Croquettes de riz à la mozzarella', 'riz,oignon,parmesan', 'INGRÉDIENTS (4 PERSONNES)\r\n\r\nPour le risotto\r\n300g de riz\r\n50 cl de bouillon de légumes\r\n1 oignon haché\r\n2 c à s de beurre\r\n50g de parmesan\r\n100g de mozzarella\r\nSel\r\nPoivre\r\nPour la panure\r\n2 oeufs\r\n50g de farine\r\n100g de chapelure\r\nHuile de friture\r\n\r\nFa', '2016-11-20 16:01:20', 'Entrée', 'img/recette/url_img_5831bac001795.jpg', 2),
(3, 'Rainbow Cake', '200 g de beurre mou 200 g de sucre en poudre 6 oeufs (environ 350 g sans la coquille) 400 g de farine de blé 1 sachet de levure chimique 25 cl de lait (1/4 litre de lait) 1 cuillerée à café de vanille en poudre  Read more at http://www.odelices.com/recett', '1. Dans un saladier, fouettez le beurre mou avec le sucre jusqu’à avoir une consistance de pommade. Incorporez les oeufs peu à peu. Incorporez ensuite la farine et la levure mélangées, puis le lait et la vanille.\r\n2. Pesez la pâte obtenue et partagez-la e', '2016-11-20 16:25:08', 'Entrée', 'img/recette/url_img_5831bfc3be0b1.jpg', 2),
(5, 'La paëlla aux fruits de mer', 'citron jaune,petits pois,gousse d\'ail,Safran ou épices à paella,Piment de Cayenne ou d\'Espelette,Poivre du moulin,poivron rouge,gros oignon,calamar,riz', 'INGRÉDIENTS (4 PERSONNES)\r\n\r\n1/2 citron jaune\r\n100g de petits pois\r\n1 gousse d\'ail\r\n1/2 botte de persil plat\r\nSel\r\nSafran ou épices à paella\r\nPiment de Cayenne ou d\'Espelette\r\nPoivre du moulin\r\n1 poivron rouge\r\n1 gros oignon\r\n200g de calamar\r\n400g de riz', '2016-11-20 16:00:32', 'Entrée', 'img/recette/url_img_5831ba90dcdd4.jpg', 2),
(6, 'Foie gras poêlé, chutney d\'oignon et vinaigre balsamique', 'escalopes de foie-gras cru,', 'INGRÉDIENTS (4 PERSONNES)\r\n\r\n4 escalopes de foie-gras cru de 50g\r\nSel et poivre du moulin\r\nPour le chutney\r\n2 gros oignons jaunes\r\n8 c à c de vinaigre de cidre\r\n2 c à s de sucre cassonade\r\n1 capsule de cardamome\r\n1 cm de gingembre frais\r\n1 clou de girofle', '2016-11-20 16:08:03', 'Entrée', 'img/recette/url_img_5831bc536c320.jpg', 2),
(7, 'Tarte à la tomate et au chèvre', 'moutarde,Herbe de Provence', 'INGRÉDIENTS (4 PERSONNES)\r\n\r\nMoutarde\r\nHerbe de Provence\r\nSel et poivre\r\n3 œufs\r\n6 tomates allongées\r\n1 bûche de chèvre\r\n1 pâte feuilletée\r\nPRÉPARATION\r\n Lire la recette\r\nÉTAPE 1 :\r\nEtalez votre pâte dans un moule.\r\nMettez de la moutarde sur le fond de pâ', '2016-11-20 16:03:31', 'Entrée', 'img/recette/url_img_5831bb43776d0.jpg', 2),
(8, 'Poulet rôti', 'sel,poivre', 'INGRÉDIENTS (6 PERSONNES)\r\n\r\nSel et poivre\r\nPaprika\r\nOignon\r\nHuile d\'olive\r\n1 gousse d\'ail\r\n1 bouquet garni\r\n1 poulet\r\nPRÉPARATION\r\n Lire la recette\r\nÉTAPE 1 :\r\nAssaisonnez l\'intérieur du poulet, avec 3 belles pincées de sel, du poivre, un peu de piment d', '2016-11-20 16:02:43', 'Entrée', 'img/recette/url_img_5831bb1384b18.jpg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `email`, `username`, `password`, `role`, `avatar`, `token`) VALUES
(2, 'Baldy', 'Valérie', 'SuperAdmin@gmail.com', 'MegaAdmin', '$2y$10$HXqHzIl9EV0Qsi99yGhelumc.jlNWunYJ82VGBVFAwFSCmAH6zCo2', 1, 'img/avatar/pic_5831e0655387f.jpg', ''),
(14, 'Dupuy', 'Brice', 'dupuybrice@orange.fr', 'Brice', '$2y$10$mW/LesFNv/v9.7k0nXQn6.7w.1eGChzKex.D6aK22q52hx18ITy8S', 2, 'img/avatar/pic_5831de3180344.jpeg', ''),
(15, 'Morand', 'Micheline', 'michelinemorand@orange.fr', 'Micheline', '$2y$10$W./VHZJyrsAXAiYwIxNpp.Pn4O9oe8.4eYB2oLve8FPl4Xna2IaMy', 2, 'img/avatar/pic_5831e1cab4013.jpeg', ''),
(16, 'Bouvier', 'Jeanne', 'Jeanne@orange.fr', 'Jeanne', '$2y$10$yUlhz26XNqdhtJ0rp2o8vui82hY9UTSp.FLn/F2aMfHpSuvzc.JO.', 2, 'img/avatar/pic_5831e1a113464.jpg', ''),
(17, 'Baldy', 'valerie', 'val-et-cyril@hotmail.fr', 'Valerie', '$2y$10$jzmmp8u5folcKxg0R174XOR/zU168NO2BUh2LatzaIk8vTkSLwQ1q', 2, 'img/pic_58318ceb604fb.jpg', ''),
(18, 'dupont', 'martin', 'martin@dupont.fr', 'martin', '$2y$10$WICZCHKkVnz/sljKEXTtKeKM9YYHI20.21ugbNhvQRNC6NCQqIbB.', 2, 'img/pic_5831b6f064284.jpg', ''),
(19, 'Sale', 'Jean', 'jeansale@gmail.com', 'JesuitraiSale', '$2y$10$Hhb8Uts9h8Vf6GguM.aduOt0lxGa7xQ.ce9O1aTYS9lLkiwnaySGO', 2, 'img/pic_5831c163ce202.png', ''),
(20, 'Propre', 'Jean', 'JeanPropre@gmail.com', 'JesuitraiPropre', '$2y$10$ulaxtar8o.j9DfM6tHBLqO/Ns0KiWDQ2dnAZnwAstNpw2V7i5djlC', 2, 'img/pic_5831c194d82ac.png', ''),
(21, 'trempé', 'Jean', 'Jeantrempe@gmail.com', 'JesuistraiTremper', '$2y$10$GAdT9D16niE5pZeJQc.I3eOWPeOI2O6Z.xyb0Kihe7wMC3RT39Owm', 2, 'img/pic_5831c1bb2fa76.png', ''),
(22, 'Sec', 'Jean', 'JeanSec@gmail.com', 'JesuitraiSec', '$2y$10$xyAX1fbJ5FmdjZBFDj1Nq.30X4IjFZofrW8QJakw.f0lFGv8sqsN6', 2, 'img/pic_5831c1dcf0107.png', ''),
(23, 'Peuplu', 'Jean', 'JeanPeuplu@gmail.com', 'JaimPaBosserLeWE', '$2y$10$XBPsORnC495XRAJyH0gaXOCv4dknEuJSNpzzVB7g5VyU.tK1D.xXu', 2, 'img/pic_5831c216c0c9b.png', ''),
(24, 'Neymar', 'Jean', 'JeaNeymar@gmail.com', 'JeaNeymar2bosserLeWE', '$2y$10$yS4b.pkytyGuu3iKo/UCCuEwCBIvD5JQvDyL0PRAYLUPF7XEXsvS6', 2, 'img/pic_5831c26f2a699.png', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contact_information`
--
ALTER TABLE `contact_information`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data` (`data`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contact_information`
--
ALTER TABLE `contact_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
