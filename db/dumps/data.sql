USE root_db;

-- Le branche sono sempre le stesse (test popolamento db)
INSERT INTO Branca (nome_branca, min_eta, max_eta) VALUES
('Lupetti', 8, 11),
('Coccinelle', 8, 11),
('Guide', 12, 16),
('Esploratori', 12, 16),
('Rover', 16, 20),
('Scolte', 16, 20),
('RS', 21, 150);
