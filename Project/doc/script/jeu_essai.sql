--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `email`, `roles`, `password`, `last_login`) VALUES
(1, 'pede@icloud.couk', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$ZTJLaGYvdDJtMUVKTFJCWQ$vHhV73SOuPb24C2fg88oQLwUC1a7eKHnfC4CEHV5Ats', NULL),
(2, 'proin.sed.turpis@protonmail.edu', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$ZnplSklHYU13aC9FSEp3eQ$SHRulI8gt/LqmH7MjBJ1lVZJE3Ec4ReBzNX2Jsq5JGg', NULL),
(3, 'nonummy.ac@icloud.edu', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$YWVmdVREdjR6aDJwbkIvaw$ppluxlgtQ1YVgyEG3vWTlaKVxnJ0qb1h20giVPzHp08', NULL),
(4, 'luctus@icloud.ca', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$OFJ4cFllNnRoc3FxbHVXOA$7k9exvWZ2nPIcsWU/v4Z8h6n18LWL6v8RPSsZIsYbLU', NULL),
(5, 'bibendum.sed@protonmail.com', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$dGpLZ2xyZDZpbXJhNzVGWQ$s0X63CtwYOEm7Jjj4gAkCnE7H2ClGg5AdQcMOvt9f1Y', NULL),
(6, 'pacolu@proteimail.com', '[\"ROLE_SUPER_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$VTZpS21vZEhZeGtEWDZLUw$tO46fN91BV35uNiyc8zw/alUM2LLtyq/vF+4YQTbc+g', NULL);

-- --------------------------------------------------------


--
-- Déchargement des données de la table `ckeditor`
--

UPDATE `ckeditor` SET `page_name`='HomePage' , `zone`='zone', `content`='<p>Texte de pr&eacute;sentaion du CSE de Saint-Vincent</p>' WHERE `id`=1;
UPDATE `ckeditor` SET `page_name`='AboutUs' , `zone`='actions', `content`='<p>Les diff&eacute;rentes actions men&eacute;es:</p><ul><li>offres permanentes</li><li>offres limit&eacute;es</li><li>reherche de partenariats</li><li>syndicats</li><li>votes</li><li>&eacute;coute</li></ul>' WHERE `id`=2;
UPDATE `ckeditor` SET `page_name`='AboutUs' , `zone`='rules', `content`='<h3><strong>Article 1 :</strong></h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In metus magna, cursus nec felis a, mattis malesuada risus. Mauris et mi nec urna accumsan iaculis. In congue erat eu sem finibus eleifend. Duis vestibulum dui nec egestas eleifend. Nulla molestie metus ac orci finibus semper. Nam non commodo risus. Duis sollicitudin et sapien quis interdum. Donec ultrices condimentum lectus, ac pellentesque tellus egestas eu. Sed scelerisque quam et nisl finibus, eu molestie tortor varius. Cras ex nulla, ornare non velit vitae, porta ultricies eros.</p><p>Pellentesque aliquet metus id magna tristique mattis. Nullam nisi augue, auctor non euismod et, tempus id neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rhoncus venenatis lorem, ut mollis erat pellentesque in. Sed tristique odio vel mauris lacinia, sit amet euismod ipsum sollicitudin. Fusce a lectus cursus, luctus elit nec, sagittis tortor. Vestibulum enim nisl, accumsan non imperdiet a, gravida sed purus. Cras tristique lacus augue, placerat finibus nulla volutpat eget. Ut viverra porttitor ultrices. Nullam maximus porta eros eu consectetur. Praesent id lacus orci. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p><h3>&nbsp;</h3><h3><strong>Article 2 :</strong></h3><p>&nbsp;</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In metus magna, cursus nec felis a, mattis malesuada risus. Mauris et mi nec urna accumsan iaculis. In congue erat eu sem finibus eleifend. Duis vestibulum dui nec egestas eleifend. Nulla molestie metus ac orci finibus semper. Nam non commodo risus. Duis sollicitudin et sapien quis interdum. Donec ultrices condimentum lectus, ac pellentesque tellus egestas eu. Sed scelerisque quam et nisl finibus, eu molestie tortor varius. Cras ex nulla, ornare non velit vitae, porta ultricies eros.</p><p>Pellentesque aliquet metus id magna tristique mattis. Nullam nisi augue, auctor non euismod et, tempus id neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. In rhoncus venenatis lorem, ut mollis erat pellentesque in. Sed tristique odio vel mauris lacinia, sit amet euismod ipsum sollicitudin. Fusce a lectus cursus, luctus elit nec, sagittis tortor. Vestibulum enim nisl, accumsan non imperdiet a, gravida sed purus. Cras tristique lacus augue, placerat finibus nulla volutpat eget. Ut viverra porttitor ultrices. Nullam maximus porta eros eu consectetur. Praesent id lacus orci. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>' WHERE `id`=3;
UPDATE `ckeditor` SET `page_name`='AboutUs' , `zone`='email', `content`='<p><a href=\'https://google.com\'><strong>cse@lyceestvincent.fr</strong></a></p>' WHERE `id`=4;

-- --------------------------------------------------------

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `name`, `firstname`, `email`, `subject`, `message`, `consent`) VALUES
(1, 'Blachard', 'Wyoming', 'pede@icloud.couk', 'Désincription newsletter', 'Bonjour, je souhaite me désinscrire de la newslettter, merci.', 1),
(2, 'Baker', 'Dorian', 'proin.sed.turpis@protonmail.edu', 'Désincription newsletter', 'Je ne suis plus intéressé par la newsletter, merci.', 1),
(3, 'Chavez', 'Ignatius', 'nonummy.ac@icloud.edu', 'Inscription newsletter', 'Bonjour, je souhaite m\'inscrire merci.', 1),
(4, 'Conner', 'Finn', 'luctus@icloud.ca', 'Stage', 'Bonjour, je souhaite postuler pour un stage.', 1),
(5, 'Baker', 'Aretha', 'bibendum.sed@protonmail.com', 'Offre intéressante', 'Bonjour, je suis intéréssé par l\'une de vos offres !', 1);


-- --------------------------------------------------------

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `first_name`, `last_name`, `profil`, `function`) VALUES
(1, 'Greg', 'Lefils', 'Greg.jpg', 'Boss'),
(2, 'Jean-Phi', 'Ling', 'Jean-Phi.jpg', 'Responsable sourire'),
(3, 'Walter', 'Deloris', 'Walter.jpg', 'UX/UI Designer'),
(4, 'Charlotte', 'Hofrès', 'Charlotte.jpg', 'Ressource humaine'),
(5, 'Anne', 'Nonym', NULL, 'Arbitre à mi-temps');

-- --------------------------------------------------------

--
-- Déchargement des données de la table `partnership`
--

INSERT INTO `partnership` (`id`, `name`, `image`, `description`, `link`) VALUES
(1, 'Google', 'googleLogo.png', '1er navigateur utilisé dans le monde !', 'https://www.google.com/'),
(2, 'Pathé', 'patheLogo.png', 'Plus gros cinéma de france !', 'https://www.pathe.fr/'),
(3, 'Mental Works', 'mentalWorksLogo.png', 'Entreprise de création de visibilité numérique', 'https://www.mentalworks.fr/'),
(4, "Macdonald\'s", 'macdonaldsLogo.png', '1er fastfood de france !', 'https://www.mcdonalds.fr/'),
(5, 'CNIL', 'logoCNIL.jpg', 'Expert en sécurité informatique', 'https://www.cnil.fr/'),
(6, 'OA', NULL, 'Organisation Annonyme', 'https://www.oa.fr/');

-- --------------------------------------------------------

--
-- Déchargement des données de la table `survey`
--

INSERT INTO `survey` (`id`, `question`, `is_active`, `datetime`, `nb_vote`) VALUES
(1, 'Aimeriez-vous avoir des déjeuner tous les matins ?', 0, '2023-03-07 15:37:33', 5),
(2, 'Quel est votre fastfood préféré ?', 0, '2023-04-12 09:30:00', 5),
(3, 'Quel est votre parc d\'attraction préféré ?', 0, '2022-12-07 18:00:00', 5),
(4, 'Quelle est la couleur du cheval blanc d\'Henri 4 ?', 0, '2023-01-07 12:00:00', 5),
(5, 'Quelle est la couleur de tes chaussettes ?', 1, '2023-04-19 15:00:00', 5);

-- --------------------------------------------------------

--
-- Déchargement des données de la table `response`
--

INSERT INTO `response` (`id`, `id_survey`, `text`, `nb_vote`) VALUES
(1, 1, 'Toujours', 1),
(2, 1, 'Jamais', 2),
(3, 1, 'De temps en temps', 2),
(4, 2, 'McDo', 2),
(5, 2, 'Burger King', 2),
(6, 2, 'KFC', 1),
(7, 3, 'Disney', 1),
(8, 3, 'Parc Astérix', 3),
(9, 3, 'La mer de sable', 1),
(10, 4, 'Rouge', 4),
(11, 4, 'Blanc', 1),
(12, 4, 'Noir', 0),
(13, 5, 'Bleues', 1),
(14, 5, 'Vertes', 1),
(15, 5, 'Jaunes', 3),
(16, 5, 'Grises', 0),
(17, 5, 'Mauves', 0);

-- --------------------------------------------------------

--
-- Déchargement des données de la table `subscriber`
--

INSERT INTO `subscriber` (`id`, `email`, `consent`) VALUES
(1, 'malesuada.fames@aol.net', 1),
(2, 'integer.in.magna@yahoo.edu', 1),
(3, 'erat.eget@protonmail.net', 1),
(4, 'faucibus@icloud.org', 1),
(5, 'vestibulum@outlook.couk', 1);

-- --------------------------------------------------------

--
-- Déchargement des données de la table `ticketing`
--

INSERT INTO `ticketing` (`id`, `id_partnership`, `slug`, `name`, `text`, `date_start`, `date_end`, `number_min_place`, `order_number`, `type`, `date_create`) VALUES
(1, 2, '1-cinema', 'Cinéma', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-07-05', '2023-07-05', 50, NULL, 'permanente', '2023-07-05'),
(2, NULL, '2-parc-asterix', 'Parc Astérix', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-07-05', '2023-07-05', 20, NULL, 'permanente', '2023-07-05'),
(3, NULL, '3-bon-decathlon', 'Bon Décathlon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-07-05', '2023-07-05', 10, NULL, 'permanente', '2023-07-05'),
(4, NULL, '4-voyage-rome', 'Voyage Rome', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-07-05', '2023-07-05', 10, NULL, 'permanente', '2022-03-01'),
(5, NULL, '5-convention-manga', 'Convention Manga', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-07-05', '2023-07-05', 30, NULL, 'permanente', '2023-07-05'),
(6, NULL, '6-lorem', 'Lorem', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-07-05', '2023-07-05', NULL, 2, 'limitée', '2022-08-07'),
(7, NULL, '7-ipsum', 'Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-07-05', '2023-07-05', NULL, 1, 'limitée', '2023-07-05'),
(8, NULL, '8-dolor', 'Dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2023-02-05', '2023-07-05', NULL, 7, 'limitée', '2023-02-05'),
(9, NULL, '9-sit', 'Sit', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-08-12', '2023-07-05', NULL, 4, 'limitée', '2022-08-12'),
(10, NULL, '10-amet', 'Amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2021-10-06', '2023-07-05', NULL, NULL, 'limitée', '2021-10-06');

-- --------------------------------------------------------

--
-- Déchargement des données de la table `image_ticketing`
--

INSERT INTO `image_ticketing` (`id`, `id_ticketing`, `name`, `numero`) VALUES
(1, 1, 'patheLogo.png', 1),
(2, 1, 'patheGaumont.jpg', 2),
(3, 1, 'patheHome.jpg', 3),
(4, 2, 'parcAsterix.jpg', 1),
(5, 3, 'decathlonMagasin.jpg', 1),
(6, 3, 'decathlonPersonnel.jpg', 2),
(7, 4, 'romeColisee.jpg', 1),
(8, 4, 'romePont.jpg', 2),
(9, 4, 'romeVille.jpg', 3),
(10, 4, 'romeVoyage.jpg', 4),
(11, 5, 'conventionManga.jpg', 1),
(12, 6, 'lorem.png', 1),
(13, 7, 'ipsum.png', 1),
(14, 8, 'dolor.jpg', 1),
(15, 9, 'sit.png', 1),
(16, 10, 'amet.jpg', 1);

-- --------------------------------------------------------

--
-- Déchargement des données de la table `user_response`
--

INSERT INTO `user_response` (`id`, `id_response`, `datetime`) VALUES
(1, 1, '2023-03-07 15:37:33'),
(2, 2, '2023-03-07 12:25:58'),
(3, 3, '2023-03-07 09:37:21'),
(4, 2, '2023-03-07 11:34:33'),
(5, 3, '2023-03-07 15:41:11'),
(6, 4, '2023-03-07 17:58:19'),
(7, 5, '2023-03-07 16:46:16'),
(8, 5, '2023-03-07 08:32:25'),
(9, 6, '2023-03-07 03:23:29'),
(10, 4, '2023-03-07 11:10:21'),
(11, 7, '2023-03-07 16:14:35'),
(12, 9, '2023-03-07 23:23:23'),
(13, 8, '2023-03-07 22:22:22'),
(14, 8, '2023-03-07 15:41:46'),
(15, 8, '2023-03-07 12:12:41'),
(16, 10, '2023-03-07 14:06:10'),
(17, 10, '2023-03-07 19:39:15'),
(18, 10, '2023-03-07 20:01:13'),
(19, 10, '2023-03-07 21:05:31'),
(20, 11, '2023-03-07 00:45:49'),
(21, 14, '2023-03-07 05:49:12'),
(22, 13, '2023-03-07 06:36:14'),
(23, 15, '2023-03-07 09:42:21'),
(24, 15, '2023-03-07 10:16:46'),
(25, 15, '2023-03-07 12:19:57');
