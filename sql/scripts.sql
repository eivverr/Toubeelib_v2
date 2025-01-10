CREATE TABLE roles (
    id VARCHAR PRIMARY KEY,
    libelle_role VARCHAR
);


CREATE TABLE users (
    id VARCHAR PRIMARY KEY,
    nom VARCHAR NOT NULL,
    prenom VARCHAR NOT NULL,
    adresse VARCHAR,
    tel VARCHAR,
    role VARCHAR,
    FOREIGN KEY (role) REFERENCES roles(id)
);


CREATE TABLE specialites (
    id VARCHAR PRIMARY KEY,
    label VARCHAR NOT NULL,
    description VARCHAR
);


CREATE TABLE specialitepraticiens (
    id_user VARCHAR,
    id_specialite VARCHAR,
    PRIMARY KEY (id_user, id_specialite),
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_specialite) REFERENCES specialites(id)
);


CREATE TABLE rdvs (
    id VARCHAR PRIMARY KEY,
    id_user VARCHAR,
    id_specialite VARCHAR,
    daterdv DATE NOT NULL,
    estAnnule BOOLEAN NOT NULL,
    statut VARCHAR,
    FOREIGN KEY (id_user) REFERENCES users(id),
    FOREIGN KEY (id_specialite) REFERENCES specialites(id)
);


INSERT INTO roles (id, libelle_role) VALUES
('1', 'Praticien'),
('2', 'Administratif'),
('3', 'Patient');

INSERT INTO users (id, nom, prenom, adresse, tel, role) VALUES
('p1', 'Dupont', 'Jean', '1 Rue Exemple', '0123456789', '1'),
('p2', 'Martin', 'Marie', '2 Rue Exemple', '0123456790', '1'),
('p3', 'Durand', 'Paul', '3 Rue Exemple', '0123456791', '1'),
('u1', 'Doe', 'John', '10 Avenue Test', '0987654321', '3'),
('u2', 'Smith', 'Anna', '11 Avenue Test', '0987654322', '3'),
('u3', 'Brown', 'Emily', '12 Avenue Test', '0987654323', '3');


INSERT INTO specialites (id, label, description) VALUES
('s1', 'Cardiologie', 'Spécialité médicale concernant les maladies du cœur et des vaisseaux.'),
('s2', 'Dermatologie', 'Spécialité médicale concernant la peau.'),
('s3', 'Pédiatrie', 'Spécialité médicale concernant les enfants.');

INSERT INTO specialitepraticiens (id_user, id_specialite) VALUES
('p1', 's1'),
('p2', 's2'),
('p3', 's3'),
('p3', 's1');


INSERT INTO rdvs (id, id_user, id_specialite, daterdv, estAnnule, statut) VALUES
('r1', 'u1', 's1', '2025-01-10', FALSE, 'Confirmé'),
('r2', 'u2', 's2', '2025-01-15', TRUE, 'Annulé'),
('r3', 'u3', 's3', '2025-01-20', FALSE, 'En attente');
