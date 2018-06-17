INSERT INTO `hg3_user` (`id`, `login`, `pass`, `hash`, `mail`, `ban`, `admin`)
VALUES
  (1, 'hiteule', '1a1dc91c907325c69271ddf0c944bc72', 'a99926175b236498aa79cce80db49bec', 'hiteule@isp.com', 0, 1);

INSERT INTO `hg3_cat` (`id`, `id_cat`, `id_souscat`, `nb_img`, `nb_souscat`, `link`, `name`, `description`, `sort`)
VALUES
    (1, 0, '', 2, 0, 'one-level', 'One Level', 'My one level gallery description', '0'),
    (2, 0, '3-4', 5, 2, 'two-level', 'Two Level', 'My two level gallery description', '1'),
    (3, 2, '', 3, 0, 'two-level/two-level-one', 'Two Level one', 'My two level one gallery description', '0'),
    (4, 2, '', 2, 0, 'two-level/two-level-two', 'Two Level two', 'My two level two gallery description', '1');


INSERT INTO `hg3_img` (`id`, `id_cat`, `date_add`, `file`, `name`, `nb_view`)
VALUES
    (1, 1, 1529178444, 'bateau_jetski.jpg', 'Bateau', 43),
    (2, 1, 1529178444, 'bebe.jpg', 'Bébé', 70),
    (3, 3, 1529178444, 'buldozer.png', 'Buldozer', 70),
    (4, 3, 1529178444, 'chant.jpg', 'Chant', 70),
    (5, 3, 1529178444, 'char.png', 'Char', 70),
    (6, 4, 1529178444, 'chateau.jpg', 'Chateau', 70),
    (7, 4, 1529178444, 'chopper.jpg', 'Chopper', 70),
    (8, 2, 1529178444, 'collier_fleur.jpg', 'Collier', 70),
    (9, 2, 1529178444, 'collier_fleur2.jpg', 'Collier', 70),
    (10, 2, 1529178444, 'crepe.jpg', 'Crèpe', 70),
    (11, 2, 1529178444, 'dodo_bateau.jpg', 'Dodo', 70);
