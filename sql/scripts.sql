CREATE TABLE roles
(
    id           VARCHAR PRIMARY KEY,
    libelle_role VARCHAR
);


CREATE TABLE users
(
    id       VARCHAR PRIMARY KEY,
    nom      VARCHAR,
    prenom   VARCHAR,
    adresse  VARCHAR,
    tel      VARCHAR,
    email    VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    role     VARCHAR NOT NULL,
    FOREIGN KEY (role) REFERENCES roles (id)
);


CREATE TABLE specialites
(
    id          VARCHAR PRIMARY KEY,
    label       VARCHAR NOT NULL,
    description VARCHAR
);


CREATE TABLE specialitepraticiens
(
    id_user       VARCHAR,
    id_specialite VARCHAR,
    PRIMARY KEY (id_user, id_specialite),
    FOREIGN KEY (id_user) REFERENCES users (id),
    FOREIGN KEY (id_specialite) REFERENCES specialites (id)
);


CREATE TABLE rdvs
(
    id            VARCHAR PRIMARY KEY,
    id_user       VARCHAR,
    id_specialite VARCHAR,
    date_debut    DATE    NOT NULL,
    date_fin      DATE    NOT NULL,
    estAnnule     BOOLEAN NOT NULL,
    statut        VARCHAR,
    FOREIGN KEY (id_user) REFERENCES users (id),
    FOREIGN KEY (id_specialite) REFERENCES specialites (id)
);

-- Table roles
INSERT INTO roles (id, libelle_role)
VALUES ('1', 'Praticien'),
       ('2', 'Administratif'),
       ('3', 'Patient');

-- Table users
INSERT INTO users (id, nom, prenom, adresse, tel, email, password, role)
VALUES ('p1', 'Dupont', 'Jean', '1 Rue Exemple', '0123456789', 'jean.dupont@example.com',
        '$2y$10$0G5jfPiEXHsxPQ8OEdj/Bev.Tc/zsE2e5QHGkeq7yEAPiF9DCG6F2', '1'), -- 123456
       ('p2', 'Martin', 'Marie', '2 Rue Exemple', '0123456790', 'marie.martin@example.com',
        '$2y$10$Q3ZlLQpJkV8sWXIhB8FztuHzpXiydb0fFkfN9A9N7fhveLrbXEK/O', '1'), -- 12345678
       ('p3', 'Durand', 'Paul', '3 Rue Exemple', '0123456791', 'paul.durand@example.com',
        '$2y$10$X3nOUy69/1ShQDWcTmD1vObh0YiMYaEBXmNvBZzApVut3sBf0bSHC', '1'), -- hello
       ('u1', 'Doe', 'John', '10 Avenue Test', '0987654321', 'john.doe@example.com',
        '$2y$10$T9t95V13s/eY0YjffS16Lus9J64QMcH5DRPEZt1oivBBS78EvKYfm', '3'), -- 1234
       ('u2', 'Smith', 'Anna', '11 Avenue Test', '0987654322', 'anna.smith@example.com',
        '$2y$10$t5FmTEufGZ2Sl60mHZKT6usQk3RlXGm55syh8UGAKi5RGU7yLg.JG', '3'), -- admin
       ('u3', 'Brown', 'Emily', '12 Avenue Test', '0987654323', 'emily.brown@example.com',
        '$2y$10$OPImJkSPn5mF7vgmNjMEW.8yB1mgzKHKeUFOmC2ZsPVL2GZ8/W5uK', '3'); -- 123


-- Table specialites
INSERT INTO specialites (id, label, description)
VALUES ('s1', 'Cardiologie', 'Spécialité médicale concernant les maladies du cœur et des vaisseaux.'),
       ('s2', 'Dermatologie', 'Spécialité médicale concernant la peau.'),
       ('s3', 'Pédiatrie', 'Spécialité médicale concernant les enfants.');

-- Table specialitepraticiens
INSERT INTO specialitepraticiens (id_user, id_specialite)
VALUES ('p1', 's1'),
       ('p2', 's2'),
       ('p3', 's3'),
       ('p3', 's1');
-- Paul Durand est spécialisé en Pédiatrie et en Cardiologie.

-- Table rdvs
INSERT INTO rdvs (id, id_user, id_specialite, date_debut, date_fin, estAnnule, statut)
VALUES ('r1', 'u1', 's1', '2025-01-10', '2025-01-10', FALSE, 'Confirmé'),
       ('r2', 'u2', 's2', '2025-01-15', '2025-01-15', TRUE, 'Annulé'),
       ('r3', 'u3', 's3', '2025-01-20', '2025-01-20', FALSE, 'En attente'),
       ('r4', 'u1', 's3', '2025-02-01', '2025-02-01', FALSE, 'Confirmé'); -- Rendez-vous supplémentaire.
