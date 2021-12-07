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
    let antwort = await fetch("Join/Accept?gameID=" + gameID);
    let status = antwort.status;
    if (status === 200) {
        addNotification("Die Einladung wurde erfolgreich akzeptiert", "success");
    } else {
        addNotification("Ein Fehler ist aufgetreten. Status Code: " + status, "error");
    }
}

function getID(id) {
    let startIndex = id.lastIndexOf("_");
    return id.substring(startIndex + 1);
}