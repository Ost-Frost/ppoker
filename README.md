# PPoker Abgabe
## GitHub URL
https://github.com/Ost-Frost/ppoker
## Gruppenmitglieder
1. Ole Reimers
2. Adam Bretzing
3. Felix Schmeißer
## Aufbau der Webseite
### MVC Model
Für die Webseite wurde das MVC Model angewendet. Dem zu Folge existiert für jede Unterseite ein Controller, ein Model und eine View, die von den entsprechenden Basisklassen vererbt sind, sowie entsprechende templates die gerendert werden. Die entsprechenden Objekte werden beim Seitenaufruf in der index.php Seite erstellt und nach dem rendern ausgegeben.
### Authentifizierung
Jede valide Unterseite kann entweder erreicht werden wenn der Benutzer eingeloggt ist **ODER** wenn der Benutzer ausgeloggt ist. Sollte der Benutzer versuchen trotzdem eine der Unterseiten zu erreichen, die nicht seinem Authentifizierungszustand entspricht wird er auf die jeweilige Startseite weitergeleitet bzw. im Falle der API wird eine entsprechende Fehlermeldung zurückgegeben. Die Authentifizierung geschieht nach dem einloggen über eine Session. Falls die userID des eingeloggten Nutzers in der Session gespeichert ist, gilt dieser als authentifiziert. Andernfalls gilt er als ausgeloggt.
### APIs
Um eine Api zu erstellen muss der Controller einer Unterseite nicht von der normalen Basisklasse vererbt werden, sondern von der abstrakten Klasse APIControllerBasis. Zu dem muss die abstrakte Methode apiCall ausimplementiert werden, die die jeweiligen API Aufrufe entsprechend verarbeitet bzw. ablehnt.
### URLs
#### Unterseiten
Unterseiten haben folgende URL ppoker/_Unterseitenname_?_Parameter_
#### APIs
API Calls haben folgende URL ppoker/_Unterseitenname_/_API-Methode_?_Parameter_
## Seitendokumentation
### Login
- Beschreibung: Startseite für ausgeloggte Nutzer. Überprüft Nutzerdaten auf Gültigkeit und loggt den Nutzer ggf. ein, indem die UserID in der Session gespeichert wird
- Erreichbarkeit: ausgeloggte Benutzer
- Requests:
  - GET: rendert die Login Seite
  - POST: versucht den Benutzer einzuloggen, rendert die entsprechende Antwortseite und leitet den Benutzer ggf. auf die Home Seite
### Logout
- Beschreibung: Loggt beim Aufruf eingeloggte Nutzer aus und leitet automatisch auf die Login Seite weiter
- Erreichbarkeit: eingeloggte Benutzer
- Requests:
  - GET: loggt den Benutzer aus und rendert die Logout Seite
### Register
- Beschreibung: Seite um neue Benutzer zu registrieren. Überprüft die Eingabedaten auf Gültigkeit und registriert ggf. neue Benutzer in der Datenbank
- Erreichbarkeit: ausgeloggte Benutzer
- Requests:
  - GET: rendert die Register Seite
  - POST: versucht den Benutzer anzulegen und rendert die entsprechende Antwortseite
### Missing Page
- Beschreibung: Seite die aufgerufen wird, wenn die angeforderte Seite nicht existiert.
- Erreichbarkeit: Immer
- Requests:
  - GET: rendert die Seite
### Home
- Beschreibung: Startseite für eingeloggte Benutzer. Bietet eine kurzer Erklärung des Spiels und Buttons, um den Benutzer auf andere Seiten weiterzuleiten.
- Erreichbarkeit: eingeloggte Benutzer
- Requests:
  - GET: rendert die Home Seite
### Create
- Beschreibung: Seite um neue Spiele und/oder Epics zu erstellen. Überprüft die Eingabedaten auf Gültigkeit und erstellt ein neues Spiel. Dieses Spiel wird entweder einer bestehenden Epic zugeordnet oder es wird eine neue Epic erstellt, welcher das Spiel anschließend zugeordnet wird. Abschließend werden die angegebenen Spieler eingeladen.
- Erreichbarkeit: eingeloggte Benutzer
- Requests:
  - GET: rendert die Create Seite
  - POST: versucht das Spiel und ggf. die Epic anzulegen, sowie die Benutzer einzuladen und rendert die entsprechende Antwortseite
### Join
- Beschreibung: Seite um Spielen zu denen der Benutzer eingeladen wurde anzuzeigen und ihnen beizutreten bzw. die Einladung abzulehnen.
- Erreichbarkeit: eingeloggte Benutzer
- Requests:
  - GET: rendert die Join Seite
### Gameoverview
#### Seite
- Beschreibung: Seite um Spiele in denen der Benutzer ist anzuzeigen, seine Karte in Spielen auzuspielen und sich die Ergebnisse der Spiele berechnen zu lassen
- Erreichbarkeit: eingeloggte Benutzer
- Requests:
  - GET: rendert die Gameoverview Seite
#### API
- getGames
  - Beschreibung: Gibt ein Array aller Epics und Spiele zurück, denen der eingeloggte Benutzer beigetreten ist.
  - Rückgabe: Ein Objekt mit zwei Listen:
    - gamesWOEpic: Eine Liste an Objekten von Spielen in denen der Benutzer ist
    - allEpic: Eine Liste an Epics in denen der Benutzer ist. Jede Epic enthält dabei zusätzlich Informationen über alle Spiele in denen der Benutzer ist und die in der jeweiligen Epic sind.
### Game
#### Seite
- Beschreibung: Diese Seite ist nur als API gedacht. Deshalb wird keine Seite gerendert sondern beim Aufruf eine Fehlermeldung zurückgegeben.
- Erreichbarkeit: eingeloggte Benutzer
- Requests:
  - GET: gibt ein leeres JSON-Objekt zurück und sendet einen Fehlercode mit.
#### API
- search
  - Beschreibung: Sucht entweder nach Benutzern, dessen Nutzername bzw. dessen E-Mail mit dem Übergabeparameter "userName" anfangen und nicht der eingeloggte Benuter sind oder nach Epics, die mit dem Übergabeparameter "epicName" anfangen und gibt diese als Liste zurück. Sind keine oder beide Parameter gesetzt wird ein Fehler ausgegeben.
  - Parameter:
    - userName|string: Der String mit dem die gesuchten Benutzernamen bzw. die E-Mail Adressen der Benutzer anfangen
    - epicName|string: Der String mit dem die gesuchten Epicnamen anfangen.
  - Rückgabe: Eine Liste an gefundenen Epicnamen bzw. Nutzernamen
- Accept
  - Beschreibung: Akzeptiert eine Einladung an den eingeloggten Benutzer für das Spiel mit der übergebenen GameID.
  - Parameter:
    - GameID|string: Die ID des Games, dessen Einladung akzeptiert werden soll.
- Decline
  - Beschreibung: Lehnt eine Einladung an den eingeloggten Benutzer für das Spiel mit der übergebenen GameID ab.
  - Parameter:
    - GameID|string: Die ID des Games, dessen Einladung abgelehnt werden soll.
- Leave
  - Beschreibung: Verlässt ein Spiel dem der eingeloggte Nutzer beigetreten ist mit der übergebenen GameID.
  - Parameter:
    - GameID|string: Die ID des Games, das verlassen werden soll.
- Delete
  - Beschreibung: Löscht ein Spiel dem der eingeloggte Nutzer erstellt hat mit der übergebenen GameID.
  - Parameter:
    - GameID|string: Die ID des Games, das gelöscht werden soll.
- Play
  - Beschreibung: Spielt eine Karte in einem Spiel dem der eingeloggte Nutzer beigetreten ist bzw. das er erstellt hat. Überprüft nicht, dass der Kartenwert einer der verfügbaren Karten ist.
  - Parameter:
    - GameID|string: Die ID des Games, das gelöscht werden soll.
    - Value|int: Der Kartenwert der gespielten Karte.