CREATE TABLE type_operation(
    id INTEGER PRIMARY KEY ,
    label VARCHAR(20)
);

CREATE TABLE tranche(
    id INTEGER PRIMARY KEY ,
    id_type INTEGER,
    montant1 NUMBER,
    montant2 NUMBER,
    FOREIGN KEY (id_type) REFERENCES type_operation(id)
);

CREATE TABLE prefixe(
    id INTEGER PRIMARY KEY ,
    label VARCHAR(20)
);

CREATE TABLE compte(
    id INTEGER PRIMARY KEY ,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    date_naissance DATE,
    gender VARCHAR(10),
    tel VARCHAR(10),
    adresse VARCHAR(50)
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
