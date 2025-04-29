USE root_db;
-- Le branche sono sempre le stesse (test popolamento db)
INSERT INTO Branca (id_branca, nome_branca, min_eta, max_eta) VALUES
(1, 'Lupetti', 8, 11),
(2, 'Coccinelle', 8, 11),
(3, 'Guide', 12, 16),
(4, 'Esploratori', 12, 16),
(5, 'Rover', 16, 20),
(6, 'Scolte', 16, 20),
(7, 'RS', 21, 150);