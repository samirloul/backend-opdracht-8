# Security Checklist (toegepast)

- Prepared statements via PDO gebruikt in alle database-acties in PdoFeature2Repository.
- Inputvalidatie: route-parameters zijn numeriek afgedwongen met whereNumber en pagina-nummer wordt begrensd op minimaal 1.
- Foutafhandeling: gebruikers krijgen alleen nette meldingen; technische details gaan naar logs.
- Least privilege: maak in MySQL een aparte app-user met alleen noodzakelijke rechten op deze database.
- Gevoelige data versleutelen: gebruik Laravel Crypt voor extra gevoelige velden wanneer je die toevoegt (bijv. privé-contactdata).
- Updates: houd Composer packages en frameworkversie actueel.
