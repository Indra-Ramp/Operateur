-- 1. Insertion de comptes fictifs pour réaliser les transactions
-- Note : id_compte1 sera l'émetteur (ou le client) et id_compte2 le destinataire (ou l'agent/distributeur)
INSERT INTO compte (id, tel) VALUES 
(1, '0341234567'), -- Client A (Telma)
(2, '0329876543'), -- Client B (Orange)
(3, '0331122334'), -- Client C (Airtel)
(4, '0340000001'), -- Compte Agent de dépôt/retrait 1
(5, '0320000002'); -- Compte Agent de dépôt/retrait 2


-- 2. Insertion d'opérations manuelles variées
-- type 1 = retrait, type 2 = transfert, type 3 = depot (selon l'ordre de vos inserts)

-- Cas A : Dépôts d'argent (Alimentation du compte chez un agent)
INSERT INTO operation (id_type, id_compte1, id_compte2, montant, date_track) VALUES
(3, 4, 1, 50000,  '2026-07-15'),  -- L'agent (4) dépose 50 000 Ar sur le compte du Client A (1)
(3, 5, 2, 150000, '2026-07-16');  -- L'agent (5) dépose 150 000 Ar sur le compte du Client B (2)

-- Cas B : Transferts de compte à compte (P2P)
INSERT INTO operation (id_type, id_compte1, id_compte2, montant, date_track) VALUES
(2, 1, 2, 20000,  '2026-07-18'),  -- Le Client A (1) transfère 20 000 Ar au Client B (2)
(2, 2, 3, 45000,  '2026-07-19'),  -- Le Client B (2) transfère 45 000 Ar au Client C (3)
(2, 1, 3, 10000,  '2026-07-20');  -- Le Client A (1) transfère 10 000 Ar au Client C (3)

-- Cas C : Retraits d'argent (Conversion en cash chez un agent)
INSERT INTO operation (id_type, id_compte1, id_compte2, montant, date_track) VALUES
(1, 3, 5, 30000,  '2026-07-20');  -- Le Client C (3) retire 30 000 Ar de cash chez l'agent (5)