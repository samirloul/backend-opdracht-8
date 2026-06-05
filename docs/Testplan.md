# Testplan Opdracht 8

## Scope
- Scenario_01: voertuig verwijderen bij instructeur
- Scenario_02: voertuig verwijderen in alle voertuigen (toegewezen)
- Scenario_03: voertuig verwijderen in alle voertuigen (niet toegewezen, non-actief)
- Pagination op 4 records

## Testgevallen

| Testcase | Voorwaarde | Stap | Verwacht |
|---|---|---|---|
| TP-01 | Data geladen | Open Instructeurs in dienst | 4 records en sortering sterren aflopend |
| TP-02 | Instructeur Mohammed bestaat | Open voertuigen van Mohammed | Sortering rijbewijs categorie aflopend |
| TP-03 | Vespa Piaggio gekoppeld | Klik Verwijderen bij Vespa | Succesmelding en na 3 sec terug, Vespa weg uit lijst |
| TP-04 | In alle voertuigen staat toegewezen voertuig | Klik kruis op toegewezen voertuig | Succesmelding en na 3 sec terug, voertuig weg |
| TP-05 | In alle voertuigen staat niet-toegewezen voertuig | Klik kruis op niet-toegewezen voertuig | Waarschuwing non-actief en melding verdwijnt na 3 sec |
| TP-06 | Meer dan 4 records beschikbaar | Gebruik paginatie | Steeds max 4 records en rustige overgang |

## Unit tests
- UT-01: removeFromAllVehicles retourneert warning bij niet toegewezen voertuig.
- UT-02: removeFromInstructor retourneert success bij geldige verwijdering.
