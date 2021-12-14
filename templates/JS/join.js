let s; //Game
let e;
function epic(event) {

    if (e != null) {
        let epicElements = getIDElements(e.id);
        epicElements.chevronRight.classList.remove("d-none");
        epicElements.chevronDown.classList.add("d-none");
        epicElements.scrollarea.classList.add("d-none");
    }
    if (e === event.currentTarget) {
        e = null;
    } else {
        e = event.currentTarget;
        let epicElements = getIDElements(e.id);
        epicElements.chevronRight.classList.add("d-none");
        epicElements.chevronDown.classList.remove("d-none");
        epicElements.scrollarea.classList.remove("d-none");
    }

    e.scrollIntoView();
    collapse();
}
function expand(event) {

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

async function accept(event) {

    let gameID = getID(event.currentTarget.id);
    let postData = new URLSearchParams();
    postData.append("gameID", gameID);
    let antwort = await fetch("Game/Accept", {method:"POST", body: postData});
    let status = antwort.status;
    if (status === 200) {
        addNotification("Die Einladung wurde erfolgreich akzeptiert", "success");
        removeGame(gameID);
    } else if (status === 400) {
        addNotification("Die Einladung ist ungültig. Bitte laden Sie die Seite neu. Status Code: " + status, "error");
        removeGame(gameID);
    } else {
        addNotification("Ein Fehler unbekannter ist aufgetreten. Bitte versuchen Sie es später erneut. Status Code: " + status, "error");
    }
}

async function decline(event) {

    let gameID = getID(event.currentTarget.id);
    let postData = new URLSearchParams();
    postData.append("gameID", gameID);
    let antwort = await fetch("Game/Decline", {method:"POST", body: postData});
    let status = antwort.status;
    if (status === 200) {
        addNotification("Die Einladung wurde erfolgreich abgelehnt", "information");
        removeGame(gameID);
    } else if (status === 400) {
        addNotification("Die Einladung ist ungültig. Bitte laden Sie die Seite neu. Status Code: " + status, "error");
        removeGame(gameID);
    } else {
        addNotification("Ein Fehler unbekannter ist aufgetreten. Bitte versuchen Sie es später erneut. Status Code: " + status, "error");
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
        information.appendChild(document.createTextNode("keine weiteren Einladungen"));
        document.getElementById("epicContent").appendChild(information);
    }
}

function getID(id) {
    let startIndex = id.lastIndexOf("_");
    return id.substring(startIndex + 1);
}