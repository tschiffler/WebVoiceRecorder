# WebVoiceRecorder
Dieses Projekt umfasst ein kleines Script welches den folgenden Prozess abbilden soll

- Es können beliebig viele Benutzer angelegt werden
- jedem Benutzer kann eine Liste von Texten zugewiesen werden, welche der User sprechen soll
- Ein User loggt sich ein und muss als erstes den Datenschutzbestimmungen zustimmen
- Nun bekommt der User einen Text angezeigt welchen er vorlesen soll
- Nachdem der Text gesprochen wurde
  - wird Der Text wird als Soundfile abgelegt
  - bekommt der User den nächsten Text zum Sprechen angezeigt

## verwendete Technologien
- Sprache: PHP
- Datenspeicher: mysql
- Voicerecorder: [recorder.js](https://github.com/mattdiamond/Recorderjs)

## Setup
- Download des Projektes
- Anpassung der Datei "config.inc.php"
- initiale Datenbank mit Scripten aus 'Documentation\01 Database-Scripts' anlegen
- Aufruf der index.php über den Browser
- Login mit Adminuser (Zugang siehe 2_basedata.sql)
- Import eines ersten Dataset über Bereich "Content-Management"
  - Beispieldatei siehe 'Documentation\02 Dataset' 
- Logout und Login mit User
- Klick auf Start - Sprechen - Klick auf Stop
- Voicefile liegt im Ordner Upload bereit