# BE-opdracht 8 - Feature 2 (Laravel)

Dit project implementeert Feature2: Verwijderen voertuig, met MVC, OOP en PDO prepared statements.

## 1. Benodigdheden

Installeer eerst:

- PHP 8.3+
- Composer
- MySQL 8+ (of MariaDB met vergelijkbare syntax)
- Git
- Node.js + npm (optioneel, niet strikt nodig voor deze versie)

## 2. Project clonen

```bash
git clone https://github.com/samirloul/backend-opdracht-8.git
cd backend-opdracht-8
```

## 3. .env instellen

Kopieer het voorbeeldbestand:

```bash
copy .env.example .env
```

Of in Git Bash:

```bash
cp .env.example .env
```

Open daarna .env en vul je databasegegevens in:

```env
APP_NAME="BE-opdracht-8"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rijschool
DB_USERNAME=jouw_gebruiker
DB_PASSWORD=jouw_wachtwoord
```

Genereer vervolgens de app key:

```bash
php artisan key:generate
```

## 4. Dependencies installeren

```bash
composer install
```

Optioneel (voor assets/workflow):

```bash
npm install
```

## 5. Database klaarzetten

Er staan SQL scripts in db.

Stap 1: voer create_database.sql uit in phpMyAdmin of MySQL client.

- Bestand: db/create_database.sql
- Dit script maakt database, tabellen, relaties en testdata aan.

Stap 2: voer stored_procedures.sql uit.

- Bestand: db/stored_procedures.sql
- Dit script maakt stored procedure sp_unassign_vehicle_from_instructeur aan.

## 6. Applicatie starten

```bash
php artisan serve
```

Open daarna:

http://127.0.0.1:8000

## 7. Routes controleren (optioneel)

```bash
php artisan route:list
```

Belangrijke pagina's:

- /
- /instructeurs
- /voertuigen

## 8. Unit tests draaien

Alle tests:

```bash
php artisan test
```

Alleen opdracht-test:

```bash
php artisan test tests/Unit/VehicleRemovalServiceTest.php
```

Verwacht resultaat: 2 tests passed.

## 9. Scenario's handmatig testen

1. Home openen.
2. Klik op Instructeurs in dienst.
3. Open voertuigen van Mohammed El Yassidi.
4. Verwijder Vespa Piaggio (Scenario 01).
5. Open Alle voertuigen.
6. Verwijder een toegewezen voertuig (Scenario 02).
7. Verwijder een niet-toegewezen voertuig (Scenario 03, non-actief melding).

## 10. Veelvoorkomende fouten



- SQLSTATE Access denied:
Controleer DB_USERNAME en DB_PASSWORD in .env.

- Base table or view not found:
Voer db/create_database.sql en db/stored_procedures.sql opnieuw uit.

## 11. Projectstructuur met opleverbestanden

- db: SQL scripts (database + stored procedures)
- docs: testplan, testrapport, ERD, class diagram, databasespecificatie
- vids: map voor je opnamevideo


