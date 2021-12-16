let s; //Game
let e;
function epic(event) {

    if (e != null) {
        let epicElements = getIDElements(e.id);
        epicElements.chevronRight.classList.remove("d-none");
        epicElements.chevronDown.classList.add("d-none");
        epicElements.scrollarea.classList.add("d-none");
        document.getElementById("epicDescription_" + e.id).classList.add("d-none");
    }
    if (e === event.currentTarget) {
        e = null;
    } else {
        e = event.currentTarget;
        let epicElements = getIDElements(e.id);
        epicElements.chevronRight.classList.add("d-none");
        epicElements.chevronDown.classList.remove("d-none");
        epicElements.scrollarea.classList.remove("d-none");
        if (e.id !== "gamesWOEpic") {
            document.getElementById("epicDescription_" + e.id).classList.remove("d-none");
        }
    }

    if (e) {
        e.scrollIntoView();
    }
    collapse();
}

function expand(event) {

    if (event.currentTarget !== event.target) {
        return false;
    }
    if (s != null) {
        let gameElements = getIDElements(s.id);
        gameElements.chevronRight.classList.remove("d-none");
        gameElements.chevronDown.classList.add("d-none");
        gameElements.scrollarea.classList.add("d-none");
    }
    if (s === event.currentTarget) {
        s = null;
    } else {
        s = event.currentTarget;
        let gameElements = getIDElements(s.id);
        gameElements.chevronRight.classList.add("d-none");
        gameElements.chevronDown.classList.remove("d-none");
        gameElements.scrollarea.classList.remove("d-none");
    }

}

function collapse() {
    if (s != null) {
        let gameElements = getIDElements(s.id);
        gameElements.chevronRight.classList.remove("d-none");
        gameElements.chevronDown.classList.add("d-none");
        gameElements.scrollarea.classList.add("d-none");
        s = null;
    }
}

function getIDElements(ID) {
    return {
        chevronRight: document.getElementById("chevronRight_" + ID),
        chevronDown: document.getElementById("chevronDown_" + ID),
        scrollarea: document.getElementById("extendedArea_" + ID)
    };
}

async function getGameData() {
    let antwort = false;
    try {
        antwort = await fetch("Gameoverview/getGames");
    } catch(e) {
        addNotification("Fehler beim Updaten der Spieldaten: " + e, "error");
        return false;
    }
    const status = antwort.status;
    if (status === 500) {
        addNotification("Fehler beim Updaten der Spieldaten. Bitte versuchen Sie es später erneut.", "error");
    } else if (status === 200) {
        return await antwort.json();
    }
    return false;
}

async function updateGameData() {
    const gameData = await getGameData();
    if (!gameData) {
        return false;
    }

    updateGameList(gameData["gamesWOEpic"]);
    let totalStoryPointsWOEpic = 0;
    gameData["gamesWOEpic"].forEach((game) => {
        totalStoryPointsWOEpic = totalStoryPointsWOEpic + Number(game["Aufwand"]);
    });
    updateEpicValue("gamesWOEpic", totalStoryPointsWOEpic, totalStoryPointsWOEpic);
    gameData["allEpic"].forEach((epic) => {
        let epicID = epic["EpicID"];
        let totalAufwand = epic["Aufwand"];
        let userAufwand = epic["currentUserValue"];
        let gameList = epic["games"];
        updateEpicValue(epicID, totalAufwand, userAufwand);
        updateGameList(gameList);
    });
}

function updateGameList(gameData) {
    gameData.forEach((game) => {
        let gameID = game["SpielID"];
        let value = game["Aufwand"];
        let userlist = game["user"];
        updateGameValue(gameID, value);
        document.getElementById("userList_" + gameID).innerHTML = "";
        userlist.forEach((user) => {
            renderPlayer(gameID, user["Username"], user["Karte"], user["Userstatus"]);
        });
    });
}

function updateEpicValue(epicID, totalValue, userValue) {
    let epicValue = document.getElementById("storyPoints_" + epicID);
    if (!epicValue) {
        return false;
    }
    epicValue.innerHTML = "";
    let valueText = totalValue;
    if (totalValue != userValue) {
        valueText += " (akuell: " + userValue + ")";
    }
    let newTextNode = document.createTextNode(valueText);
    epicValue.appendChild(newTextNode);
}

function updateGameValue(gameID, value) {
    let gameValue = document.getElementById("storyPoints_" + gameID);
    gameValue.innerHTML = "";
    let newTextNode = document.createTextNode(value);
    gameValue.appendChild(newTextNode);
}

function renderPlayer(gameID, userName, cardValue, userStatus) {
    let userlist = document.getElementById("userList_" + gameID);
    let newUserElement = document.createElement("li");
    let cardText = cardValue;
    if (cardValue == 0 || userStatus == 0) {
        cardText = "ausstehend";
    }
    if (userStatus == 4) {
        cardText = "abgelehnt";
    }
    if (userStatus == 3 && cardValue == 0) {
        cardText = "vorzeitig verlassen"
    }
    let textNode = document.createTextNode(userName + ": " + cardText);
    newUserElement.appendChild(textNode);
    userlist.appendChild(newUserElement);
}

async function playCard(event) {

    event.preventDefault();
    let gameID = getID(event.currentTarget.id);
    let cardValue = getCardValue(event.currentTarget.id);
    let postData = new URLSearchParams();
    postData.append("gameID", gameID);
    postData.append("value", cardValue);
    let antwort = false;
    try {
        antwort = await fetch("Game/Play", {method:"POST", body: postData});
    } catch (e) {
        addNotification("Beim spielen der Karte ist ein Fehler aufgetreten: " + e, "error");
    }
    alert(await antwort.text());
    let status = antwort.status;
    if (status === 200) {
        addNotification("Die Karte wurde erfolgreich gespielt", "success");
        updateGameData();
    } else if (status === 400) {
        addNotification("Das Spiel ist ungültig. Bitte laden Sie die Seite neu. " + status, "error");
    } else {
        addNotification("Ein unbekannter Fehler ist aufgetreten. Bitte versuchen Sie es später erneut. Status Code: " + status, "error");
    }
}

async function leave(event) {

    let gameID = getID(event.currentTarget.id);
    let postData = new URLSearchParams();
    postData.append("gameID", gameID);
    let antwort = false;
    try {
        antwort = await fetch("Game/Leave", {method:"POST", body: postData});
    } catch (e) {
        addNotification("Beim verlassen des Spiels ist ein Fehler aufgetreten: " + e, "error");
    }
    let status = antwort.status;
    if (status === 200) {
        addNotification("Das Spiel wurde erfolgreich verlassen.", "information");
        removeGame(gameID);
    } else if (status === 400) {
        addNotification("Das Spiel ist ungültig. Bitte laden Sie die Seite neu. Status Code: " + status, "error");
        removeGame(gameID);
    } else {
        addNotification("Ein unbekannter Fehler ist aufgetreten. Bitte versuchen Sie es später erneut. Status Code: " + status, "error");
    }
}

async function deleteGame(event) {

    let gameID = getID(event.currentTarget.id);
    let postData = new URLSearchParams();
    postData.append("gameID", gameID);
    let antwort = false;
    try {
        antwort = await fetch("Game/Delete", {method:"POST", body: postData});
    } catch (e) {
        addNotification("Beim löcshen des Spiels ist ein Fehler aufgetreten: " + e, "error");
    }
    alert (await antwort.text());
    let status = antwort.status;
    if (status === 200) {
        addNotification("Das Spiel wurde erfolgreich gelöscht.", "information");
        removeGame(gameID);
    } else if (status === 400) {
        addNotification("Das Spiel ist ungültig. Bitte laden Sie die Seite neu. Status Code: " + status, "error");
        removeGame(gameID);
    } else {
        addNotification("Ein unbekannter Fehler ist aufgetreten. Bitte versuchen Sie es später erneut. Status Code: " + status, "error");
    }
}

function removeGame(gameID) {
    let gameElement = document.getElementById(gameID);
    let parentElement = gameElement.parentElement;
    gameElement.remove();
    s = null;
    if (parentElement.children.length === 0) {
        parentElement.parentElement.remove();
        e = null;
    }

    if (document.getElementById("epicContent").children.length === 0) {
        let information = document.createElement("h1");
        information.classList.add("m-4");
        information.appendChild(document.createTextNode("Sie haben aktuell keine Spiele."));
        document.getElementById("epicContent").appendChild(information);
    }
}

function getID(id) {
    let startIndex = id.lastIndexOf("_");
    return id.substring(startIndex + 1);
}

function getCardValue(id) {
    let startIndex = id.indexOf("_");
    let endIndex = id.lastIndexOf("_");
    return id.substring(startIndex + 1, endIndex);
}

document.addEventListener("DOMContentLoaded", () => {
    updateGameData();
});