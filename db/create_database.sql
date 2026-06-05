-- Opdracht 8 - create script (structuur + data + relaties)
-- MySQL 8+
create database if not exists rijschool;
use rijschool;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS instructeur_voertuigen;
DROP TABLE IF EXISTS voertuigen;
DROP TABLE IF EXISTS type_voertuigen;
DROP TABLE IF EXISTS instructeurs;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE instructeurs (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Voornaam VARCHAR(80) NOT NULL,
    Tussenvoegsel VARCHAR(30) NULL,
    Achternaam VARCHAR(120) NOT NULL,
    Mobiel VARCHAR(20) NOT NULL,
    DatumInDienst DATE NOT NULL,
    AantalSterren TINYINT UNSIGNED NOT NULL DEFAULT 0,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

CREATE TABLE type_voertuigen (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    TypeVoertuig VARCHAR(80) NOT NULL,
    Rijbewijscategorie VARCHAR(4) NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

CREATE TABLE voertuigen (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    TypeVoertuigId INT UNSIGNED NOT NULL,
    Kenteken VARCHAR(16) NOT NULL UNIQUE,
    Bouwjaar YEAR NOT NULL,
    BrandstofType VARCHAR(30) NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_voertuigen_type FOREIGN KEY (TypeVoertuigId) REFERENCES type_voertuigen (Id)
);

CREATE TABLE instructeur_voertuigen (
    Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    InstructeurId INT UNSIGNED NOT NULL,
    VoertuigId INT UNSIGNED NOT NULL,
    DatumToewijzing DATE NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(250) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_iv_instructeur FOREIGN KEY (InstructeurId) REFERENCES instructeurs (Id),
    CONSTRAINT fk_iv_voertuig FOREIGN KEY (VoertuigId) REFERENCES voertuigen (Id),
    CONSTRAINT uq_actieve_toewijzing UNIQUE (InstructeurId, VoertuigId, IsActief)
);

INSERT INTO instructeurs (Voornaam, Tussenvoegsel, Achternaam, Mobiel, DatumInDienst, AantalSterren, IsActief, Opmerking)
VALUES
('Mohammed', 'El', 'Yassidi', '06-12345678', '2018-05-20', 5, b'1', 'Senior instructeur.'),
('Laila', NULL, 'Bakker', '06-98765432', '2020-10-15', 4, b'1', NULL),
('Sven', 'de', 'Vries', '06-11112222', '2019-04-08', 3, b'1', NULL),
('Nora', NULL, 'Visser', '06-33334444', '2021-03-01', 2, b'1', NULL),
('Joris', NULL, 'Meijer', '06-55556666', '2022-06-12', 1, b'1', NULL);

INSERT INTO type_voertuigen (TypeVoertuig, Rijbewijscategorie, IsActief)
VALUES
('Auto', 'B', b'1'),
('Vespa Piaggio', 'AM', b'1'),
('Bus', 'D', b'1'),
('Vrachtwagen', 'C', b'1');

INSERT INTO voertuigen (TypeVoertuigId, Kenteken, Bouwjaar, BrandstofType, IsActief)
VALUES
(1, 'AA-10-BB', 2024, 'Elektrisch', b'1'),
(2, 'MC-11-DD', 2021, 'Benzine', b'1'),
(3, 'BS-20-KK', 2023, 'Diesel', b'1'),
(4, 'VR-99-ZZ', 2022, 'Diesel', b'1'),
(1, 'AB-23-CD', 2019, 'Hybride', b'1'),
(2, 'SN-77-GH', 2018, 'Benzine', b'1'),
(1, 'XY-55-JK', 2017, 'Benzine', b'1');

INSERT INTO instructeur_voertuigen (InstructeurId, VoertuigId, DatumToewijzing, IsActief, Opmerking)
VALUES
(1, 2, '2025-01-10', b'1', 'Vespa Piaggio gekoppeld aan Mohammed El Yassidi'),
(1, 1, '2025-01-11', b'1', NULL),
(2, 3, '2025-02-01', b'1', NULL),
(3, 4, '2025-02-10', b'1', NULL),
(4, 5, '2025-02-20', b'1', NULL);
