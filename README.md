# RundenMeister

RundenMeister ist ein einfaches System zur Erfassung von Rundenzeiten bei Laufveranstaltungen, besonders geeignet für Schulveranstaltungen.

## API-Dokumentation

Die API verwendet JSON für die Kommunikation. Alle Anfragen müssen als POST-Requests gesendet werden.

### Runde hinzufügen

*Anfrage*

Um eine Runde hinzuzufügen, senden Sie eine POST-Anfrage an die API mit folgendem JSON-Body:

```json
{
    "action": "add_lap",
    "runner_id": "RUNNER_ID",
    "type": "lap"
}

* action: Muss immer "add_lap" sein.
* runner_id: Die eindeutige ID des Läufers.
* type: Der Typ der Runde, kann "start", "lap" oder "finish" sein.

*Antwort*

* Bei Erfolg: Die ID der hinzugefügten Runde.
* Bei Fehler: Eine Fehlermeldung, z.B. "🚨 Die Runde wurde zu früh hinzugefügt.".

### Ergebnisse anzeigen

Um alle erfassten Runden für einen Läufer bzw. eine Läuferin anzuzeigen, nutzen Sie folgende Anfrage:

```json
{
    "action": "get_laps",
    "runner_id": "RUNNER_ID"
}