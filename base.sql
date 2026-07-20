CREATE TABLE type_operation(
    id INTEGER PRIMARY KEY ,
    label VARCHAR(20)
);

ALTER TABLE type_operation ADD description TEXT;

CREATE TABLE tranche(
    id INTEGER PRIMARY KEY ,
    id_type INTEGER,
    montant1 NUMBER,
    montant2 NUMBER,
    frais NUMBER,
    FOREIGN KEY (id_type) REFERENCES type_operation(id)
);

CREATE TABLE prefixe(
    id INTEGER PRIMARY KEY ,
    label VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE compte(
    id INTEGER PRIMARY KEY ,
    tel VARCHAR(10)
);

CREATE TABLE operation(
    id INTEGER PRIMARY KEY ,
    id_type INTEGER,
    id_compte1 INTEGER,
    id_compte2 INTEGER,
    montant NUMBER,
    date_track DATE,
    FOREIGN KEY (id_type) REFERENCES type_operation(id),
    FOREIGN KEY (id_compte1) REFERENCES compte(id),
    FOREIGN KEY (id_compte2) REFERENCES compte(id)
);

CREATE INDEX idx_tel ON compte(tel);
INSERT INTO prefixe('label') VALUES
('032'),
('033'),
('034'),
('035'),
('036'),
('037'),
('038');

INSERT INTO type_operation (label) VALUES
('retrait'), ('transfert'), ('depot');

UPDATE type_operation SET description=
"Opérations de retrait via agents ou distributeurs. Définissez des frais fixes ou en pourcentage."
WHERE label = 'retrait';

UPDATE type_operation SET description=
"Envois de fonds de compte à compte ou vers l'externe. Ajustez les grilles tarifaires."
WHERE label = 'transfert';

UPDATE type_operation SET description=
"Transactions de dépôt et alimentation de compte. Gérez les commissions agents."
WHERE label = 'depot';

