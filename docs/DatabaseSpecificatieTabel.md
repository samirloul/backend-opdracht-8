# Database Specificatie Tabel

## Tabel: instructeurs

| Veld | Type | Null | Sleutel | Omschrijving |
|---|---|---|---|---|
| Id | INT UNSIGNED | Nee | PK | Uniek ID instructeur |
| Voornaam | VARCHAR(80) | Nee |  | Voornaam |
| Tussenvoegsel | VARCHAR(30) | Ja |  | Tussenvoegsel |
| Achternaam | VARCHAR(120) | Nee |  | Achternaam |
| Mobiel | VARCHAR(20) | Nee |  | Mobiele telefoon |
| DatumInDienst | DATE | Nee |  | Datum in dienst |
| AantalSterren | TINYINT UNSIGNED | Nee |  | Rating |
| IsActief | BIT | Nee |  | Systeemveld |
| Opmerking | VARCHAR(250) | Ja |  | Systeemveld |
| DatumAangemaakt | DATETIME(6) | Nee |  | Systeemveld |
| DatumGewijzigd | DATETIME(6) | Nee |  | Systeemveld |

## Tabel: type_voertuigen

| Veld | Type | Null | Sleutel | Omschrijving |
|---|---|---|---|---|
| Id | INT UNSIGNED | Nee | PK | Uniek ID type |
| TypeVoertuig | VARCHAR(80) | Nee |  | Naam voertuigtype |
| Rijbewijscategorie | VARCHAR(4) | Nee |  | Rijbewijs klasse |
| IsActief | BIT | Nee |  | Systeemveld |
| Opmerking | VARCHAR(250) | Ja |  | Systeemveld |
| DatumAangemaakt | DATETIME(6) | Nee |  | Systeemveld |
| DatumGewijzigd | DATETIME(6) | Nee |  | Systeemveld |

## Tabel: voertuigen

| Veld | Type | Null | Sleutel | Omschrijving |
|---|---|---|---|---|
| Id | INT UNSIGNED | Nee | PK | Uniek voertuig ID |
| TypeVoertuigId | INT UNSIGNED | Nee | FK | Verwijst naar type_voertuigen.Id |
| Kenteken | VARCHAR(16) | Nee | UQ | Kenteken |
| Bouwjaar | YEAR | Nee |  | Bouwjaar |
| BrandstofType | VARCHAR(30) | Nee |  | Brandstofsoort |
| IsActief | BIT | Nee |  | Systeemveld |
| Opmerking | VARCHAR(250) | Ja |  | Systeemveld |
| DatumAangemaakt | DATETIME(6) | Nee |  | Systeemveld |
| DatumGewijzigd | DATETIME(6) | Nee |  | Systeemveld |

## Tabel: instructeur_voertuigen

| Veld | Type | Null | Sleutel | Omschrijving |
|---|---|---|---|---|
| Id | INT UNSIGNED | Nee | PK | Uniek koppel ID |
| InstructeurId | INT UNSIGNED | Nee | FK | Verwijst naar instructeurs.Id |
| VoertuigId | INT UNSIGNED | Nee | FK | Verwijst naar voertuigen.Id |
| DatumToewijzing | DATE | Nee |  | Datum koppeling |
| IsActief | BIT | Nee |  | Systeemveld |
| Opmerking | VARCHAR(250) | Ja |  | Systeemveld |
| DatumAangemaakt | DATETIME(6) | Nee |  | Systeemveld |
| DatumGewijzigd | DATETIME(6) | Nee |  | Systeemveld |
