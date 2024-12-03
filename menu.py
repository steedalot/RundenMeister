import requests
import json
from datetime import datetime

url = "https://lauf.phoenixgymnasium.de"

def print_menu():
    print("\n=== RundenMeister Menu ===")
    print("1. Läufer-ID festlegen")
    print("2. Neue Runde hinzufügen")
    print("3. Alle Runden anzeigen")
    print("4. Beenden")

def add_lap(runner_id):
    data = {
        "action": "add_lap",
        "runner_id": runner_id,
        "type": "lap"
    }
    response = requests.post(url, json=data)
    if response.status_code == 200:
        print("✅ Runde erfolgreich hinzugefügt!")
    else:
        print(f"❌ Fehler: {response.text}")

def get_laps(runner_id):
    data = {
        "action": "get_laps",
        "runner_id": runner_id
    }
    response = requests.post(url, json=data)
    if response.status_code == 200:
        print(response.text)
        laps = response.json()

        print("\n=== Runden ===")
        previous_timestamp = None
        for lap in laps:
            timestamp = datetime.fromtimestamp(int(lap['timestamp'])).strftime('%d.%m.%Y %H:%M:%S')
            if lap['type'] == 'lap' and previous_timestamp:
                time_diff = int(lap['timestamp']) - previous_timestamp
                if time_diff > 60:
                    print(f"Typ: {lap['type']}, Zeit: {lap['timestamp']} ({timestamp}), Zeit seit letzter Runde: {time_diff // 60} Minuten {time_diff % 60} Sekunden")
                else:
                    print(f"Typ: {lap['type']}, Zeit: {lap['timestamp']} ({timestamp}), Zeit seit letzter Runde: {time_diff} Sekunden")
            else:
                print(f"Typ: {lap['type']}, Zeit: {lap['timestamp']} ({timestamp})")
                previous_timestamp = int(lap['timestamp'])
    else:
        print(f"❌ Fehler: {response.text}")

def main():
    runner_id = None
    while True:
        print_menu()
        if runner_id:
            print(f"\nAktueller Läufer: {runner_id}")
        
        choice = input("\nWähle eine Option (1-4): ")
        
        if choice == "1":
            runner_id = input("Gib die Läufer-ID ein: ")
        elif choice == "2":
            if runner_id:
                add_lap(runner_id)
            else:
                print("❌ Bitte zuerst Läufer-ID setzen!")
        elif choice == "3":
            if runner_id:
                get_laps(runner_id)
            else:
                print("❌ Bitte zuerst Läufer-ID setzen!")
        elif choice == "4":
            print("Auf Wiedersehen!")
            break
        else:
            print("❌ Ungültige Eingabe!")

if __name__ == "__main__":
    main()
