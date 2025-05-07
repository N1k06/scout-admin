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

-- iters divisi per branca
INSERT INTO Iter(nome, id_branca) VALUES
-- 1. LUPETTI:
('cucciolo', 1),
('zampa tenera', 1),
('1° stella', 1),
('2° stella', 1),
('lupo anziano', 1),

-- 2. COCCINELLE:
('cocci', 2),
('coccinella', 2),
('mughetto', 2),
('genziana', 2),

-- 3. GUIDE:
('gui', 3),
('guida', 3),
('1° classe', 3),
('2° classe', 3),

-- 4. ESPLORATORI:
('novizio', 4),
('piede tenero', 4),
('2° classe', 4),
('1° classe', 4),
('esploratore scelto', 4),

-- 5. ROVER:
('novizio', 5),
('rover', 5),

-- 6. SCOLTE:
('scolta viandante', 6),
('scolta semplice', 6),

-- 7. RS:
('responsabile', 7);