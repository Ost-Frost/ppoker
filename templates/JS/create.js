const userList = [];
let newEpic = false;
let epicSelected = "";

async function autoComplete(event) {
  let input = event.target.value;
  let foundData = (event.target.id === "suche") ? await searchUsers(input) : await searchEpics(input);
  document.getElementById("suggestions").innerHTML = "";
  createSuggestions(foundData, event.target.id);
}

function keyPressSearch(event) {
  if (event.key !== "Enter") {
    return;
  }
  event.preventDefault();
  if (event.target.id === "suche") {
    addUser();
  } else {
    addEpic();
  }
}

function createSuggestions(list, searchFieldID) {
  let suggestionsID = (searchFieldID === "suche") ? "suggestions" : "suggestionsEpic";
  let suggestions = document.getElementById(suggestionsID);
  suggestions.innerHTML = "";
  let input = document.getElementById(searchFieldID);
  if (searchFieldID === "suche") {
    list = list.filter((element) => {
      for (let curUser of userList) {
        if (element === curUser) {
          return false;
        }
      }
      return true;
    })
  }
  list.splice(5);
  for (let curSuggestion of list) {
    if (input.value == curSuggestion) {
      continue;
    }
    if (curSuggestion.length > 20) {
      curSuggestion = curSuggestion.substring(0, 20) + "...";
    }
    let newElement = document.createElement("button");
    newElement.classList.add("list-group-item");
    let clickFunction = (searchFieldID === "suche") ? acceptSuggestion : acceptSuggestionEpic;
    newElement.addEventListener("click", clickFunction);
    newElement.setAttribute("type", "button");
    newElement.innerHTML=curSuggestion;
    suggestions.appendChild(newElement);
  }
}

// --------- User functions -----------------------------------------
async function searchUsers(input) {
  let foundUsernames = [];
  if (input !== "") {
    let antwort = await fetch("Game/Search?userName=" + input);
    foundUsernames = await antwort.json();
    if (foundUsernames === {}) {
      foundUsernames = [];
    }
  }
  return foundUsernames;
}

async function acceptSuggestion(event) {
  event.preventDefault();
  document.getElementById("suche").value = event.target.innerHTML;
  await addUser();
  event.target = document.getElementById("suche");
  autoComplete(event);
  document.getElementById("suche").focus();
}

async function addUser() {
  let input = document.getElementById("suche").value;
  let foundUsernames = await searchUsers(input);
  let userExists = false;
  let userAlreadyFound = false;
  for (let curUser of foundUsernames) {
    if (curUser == input) {
      userExists = true;
    }
  }

  for (let curUser of userList) {
    if (curUser == input) {
      userAlreadyFound = true;
    }
  }
  if (!userExists || userAlreadyFound) {
    return;
  }

  userList.push(input);
  buildUserList();
  document.getElementById("suche").value = "";
}

function buildUserList() {
  document.getElementById("antwort").innerHTML = "";
  for (let curUser of userList) {
    let newUserElement = document.createElement("div");
    newUserElement.classList.add("list-group-item");
    newUserElement.classList.add("flex");
    newUserElement.classList.add("align-items-center");
    newUserElement.setAttribute("id", "User" + curUser);
    let deleteButton = document.createElement("button");
    deleteButton.classList.add("btn-close");
    deleteButton.classList.add("btn-sm")
    deleteButton.addEventListener("click", removeUser);
    deleteButton.setAttribute("type", "button");
    deleteButton.setAttribute("id", "btnUser" + curUser);
    deleteButton.setAttribute("aria-label", "Close");
    let userTextNode = document.createTextNode(" " + curUser);
    newUserElement.appendChild(deleteButton);
    newUserElement.appendChild(userTextNode);
    document.getElementById("antwort").appendChild(newUserElement);
  }
}

function removeUser(event) {
  userName = event.target.id.substring(7);
  userIndex = userList.indexOf(userName);
  userList.splice(userIndex, 1);

  buildUserList();
};

// --------- Epic functions -----------------------------------------
function switchEpic(event) {
  let switchTo = "Select";
  if (event.target.id === "btnSwitchEpicCreate") {
    switchTo = "Create";
  }

  let selectElement = document.getElementById("epicSelect");
  let createElement = document.getElementById("epicCreate");
  let epicHeaderElement = document.getElementById("epicHeader");

  if (switchTo === "Select") {
    selectElement.classList.remove("d-none");
    createElement.classList.add("d-none");
    newEpic = false;
    epicHeaderElement.innerHTML = "Epic auswählen";
  } else {
    selectElement.classList.add("d-none");
    createElement.classList.remove("d-none");
    newEpic = true;
    epicHeaderElement.innerHTML = "Epic erstellen";
  }
}

async function acceptSuggestionEpic(event) {
  event.preventDefault();
  document.getElementById("sucheEpic").value = event.target.innerHTML;
  await addEpic();
  event.target = document.getElementById("sucheEpic");
  autoComplete(event);
  document.getElementById("sucheEpic").focus();
}

async function searchEpics(input) {
  let foundEpics = [];
  if (input !== "") {
    let antwort = await fetch("Game/Search?userName=" + input);
    foundEpics = await antwort.json();
    if (foundEpics === {}) {
      foundEpics = [];
    }
  }
  return foundEpics;
}

async function addEpic() {
  let input = document.getElementById("sucheEpic").value;
  let foundEpics = await searchEpics(input);
  let epicExists = false;
  for (let curEpic of foundEpics) {
    if (curEpic == input) {
      epicExists = true;
    }
  }

  if (!epicExists) {
    return;
  }

  epicSelected = input;
  document.getElementById("epicSelect").classList.add("d-none");
  buildEpic(epicSelected);
}

function buildEpic(epicName) {
  document.getElementById("epicSelected").innerHTML = "";
  let epicElement = document.createElement("div");
  epicElement.classList.add("list-group-item");
  epicElement.classList.add("flex");
  epicElement.classList.add("align-items-center");
  let deleteButton = document.createElement("button");
  deleteButton.classList.add("btn-close");
  deleteButton.classList.add("btn-sm")
  deleteButton.addEventListener("click", removeEpic);
  deleteButton.setAttribute("type", "button");
  deleteButton.setAttribute("aria-label", "Close");
  let epicTextNode = document.createTextNode(" " + epicName);
  epicElement.appendChild(deleteButton);
  epicElement.appendChild(epicTextNode);
  document.getElementById("epicSelected").appendChild(epicElement);
}

function removeEpic() {
  epicName = "";
  document.getElementById("epicSelected").innerHTML = "";
  document.getElementById("epicSelect").classList.remove("d-none");
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("suche").addEventListener("input", autoComplete);
  document.getElementById("suche").addEventListener("keypress", keyPressSearch);
  document.getElementById("inviteBtn").addEventListener("click", addUser);

  document.getElementById("sucheEpic").addEventListener("input", autoComplete);
  document.getElementById("sucheEpic").addEventListener("keypress", keyPressSearch);
  document.getElementById("btnEpicSelect").addEventListener("click", addEpic);
  document.getElementById("btnSwitchEpicCreate").addEventListener("click", switchEpic);
  document.getElementById("btnSwitchEpicSelect").addEventListener("click", switchEpic);
});
