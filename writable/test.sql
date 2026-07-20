-- 1. Configuration des Opérateurs Tiers uniquement
INSERT INTO operateur (id, label) VALUES
(2, 'Airtel Money'),
(3, 'Orange Money'),
(4, 'Blueline');

-- 2. Configuration des Préfixes (id_operateur à NULL = Notre Opérateur)
INSERT INTO prefixe (id, label, id_operateur) VALUES
(1, '032', NULL), -- Notre Opérateur (absent de la table operateur)
(2, '033', 2),    -- Airtel Money
(3, '034', 3),    -- Orange Money
(4, '035', 4),    -- Blueline
(5, '036', 4),    -- Blueline
(6, '037', 3),    -- Orange Money
(7, '038', NULL); -- Notre Opérateur (absent de la table operateur)

-- 3. Pourcentages de commission pour les transferts externes
INSERT INTO commission (id, id_operateur, perc) VALUES
(1, 2, 0.025), -- Airtel Money : 2.5%
(2, 3, 0.030), -- Orange Money : 3.0%
(3, 4, 0.020); -- Blueline     : 2.0%

-- 4. Grille des Frais par Tranches (1: retrait, 2: transfert, 3: depot)
-- Tranches pour Retrait (id_type = 1)
INSERT INTO tranche (id, id_type, montant1, montant2, frais) VALUES
(1, 1, 1000, 5000, 100),
(2, 1, 5001, 20000, 300),
(3, 1, 20001, 100000, 1000),
(4, 1, 100001, 500000, 3500);

-- Tranches pour Transfert (id_type = 2)
INSERT INTO tranche (id, id_type, montant1, montant2, frais) VALUES
(5, 2, 1000, 5000, 50),
(6, 2, 5001, 20000, 150),
(7, 2, 20001, 100000, 500),
(8, 2, 100001, 500000, 2000);

-- 5. Création des comptes de test (id_compte1 a un préfixe associé à un id_operateur NULL)
INSERT INTO compte (id, tel) VALUES
-- Notre Opérateur (Émetteurs obligatoires ou Récepteurs internes)
(1, '0321122233'),
(2, '0385566677'),
(3, '0329988877'),
-- Opérateurs Externes (Uniquement récepteurs de transferts)
(4, '0334455566'), -- Airtel
(5, '0347788899'), -- Orange
(6, '0351144477'); -- Blueline

-- 6. Insertion directe des opérations cohérentes
INSERT INTO operation (id, id_type, id_compte1, id_compte2, montant, date_track, id_operateur, frais, commission) VALUES
-- A. Dépôts (id_compte2 = NULL, id_operateur = NULL, frais = 0, commission = 0)
(1, 3, 1, NULL, 50000, '2026-07-15', NULL, 0, 0),
(2, 3, 2, NULL, 150000, '2026-07-16', NULL, 0, 0),

-- B. Retraits (id_compte2 = NULL, id_operateur = NULL, frais selon tranche)
-- Mnt: 4000 Ar -> Tranche 1 (Frais: 100 Ar)
(3, 1, 1, NULL, 4000, '2026-07-16', NULL, 100, 0),
-- Mnt: 30000 Ar -> Tranche 3 (Frais: 1000 Ar)
(4, 1, 2, NULL, 30000, '2026-07-17', NULL, 1000, 0),

-- C. Transferts Internes (id_compte2 obligatoire [Notre Op.], id_operateur = NULL, commission = 0)
-- Mnt: 15000 Ar -> Tranche 6 (Frais: 150 Ar)
(5, 2, 1, 2, 15000, '2026-07-18', NULL, 150, 0),
-- Mnt: 120000 Ar -> Tranche 8 (Frais: 2000 Ar)
(6, 2, 2, 3, 120000, '2026-07-18', NULL, 2000, 0),

-- D. Transferts Externes (id_compte2 obligatoire [Tiers], id_operateur fait référence à la table operateur)
-- Vers Airtel (id_op=2, 2.5%), Mnt: 10000 Ar -> Tranche 6 (Frais: 150 Ar) | Comm: 10000 * 2.5% = 250 Ar
(7, 2, 1, 4, 10000, '2026-07-19', 2, 150, 250),
-- Vers Orange (id_op=3, 3.0%), Mnt: 200000 Ar -> Tranche 8 (Frais: 2000 Ar) | Comm: 200000 * 3.0% = 6000 Ar
(8, 2, 2, 5, 200000, '2026-07-20', 3, 2000, 6000),
-- Vers Blueline (id_op=4, 2.0%), Mnt: 3000 Ar -> Tranche 5 (Frais: 50 Ar) | Comm: 3000 * 2.0% = 60 Ar
(9, 2, 3, 6, 3000, '2026-07-20', 4, 50, 60);