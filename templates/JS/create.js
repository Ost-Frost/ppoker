/**
 * list of invited users
 */
const userList = [];

/**
 * true if a new epic should be created
 */
let newEpic = false;

/**
 * currently selected epic
 */
let epicSelected = "";

/**
 * max number of suggestions to be shown while searching
 */
const MAX_SUGGESTIONS = 5;

/**
 * asynchronous function
 * the autoComplete function for the search bars
 *
 * @param {Event} event
 */
async function autoComplete(event) {
  let input = event.target.value;
  let foundData = false;
  if (event.target.id === "suche") {
    foundData = await searchUsers(input);
  } else if (event.target.id === "sucheEpic") {
    foundData = await searchUsers(input);
  } else {
    return;
  }
  createSuggestions(foundData, event.target.id);
}

/**
 * keyPress event function for the search bars. changes enter press from default behaviour to add searched user/epic
 *
 * @param {Event} event
 */
function keyPressSearch(event) {
  if (event.key !== "Enter") {
    return;
  }
  event.preventDefault();
  if (event.target.id === "suche") {
    addUser();
  } else if (event.target.id === "sucheEpic"){
    addEpic();
  }
}

/**
 * creates suggestions for a searchField
 *
 * @param {Array} list list of suggestions
 * @param {String} searchFieldID id of the search field
 */
function createSuggestions(list, searchFieldID) {

  // get parameters
  let suggestionsID;
  let clickFunction;
  if (searchFieldID === "suche") {
    suggestionsID = "suggestions";
    clickFunction = acceptSuggestion;
  } else if (searchFieldID === "sucheEpic") {
    suggestionsID = "suggestionsEpic";
    clickFunction = acceptSuggestionEpic;
  } else {
    return;
  }
  let input = document.getElementById(searchFieldID);

  // clear previous suggestions
  let suggestions = document.getElementById(suggestionsID);
  suggestions.innerHTML = "";

  // clear already added users from userSuggestions
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

  // limit suggestion number
  list.splice(MAX_SUGGESTIONS);

  // build suggestion elements
  for (let curSuggestion of list) {
    let newElement = document.createElement("button");
    newElement.classList.add("list-group-item");
    newElement.addEventListener("click", clickFunction);
    newElement.setAttribute("type", "button");
    newElement.innerHTML=curSuggestion;
    suggestions.appendChild(newElement);
  }
}

// --------- User functions -----------------------------------------

/**
 * search for users on the server whose userName or Email start with given input
 *
 * @param {String} input userName or email to search for
 */
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

/**
 * event when a suggestion in the userName search bar is accepted
 *
 * @param {Event} event
 */
async function acceptSuggestion(event) {
  event.preventDefault();
  document.getElementById("suche").value = event.target.innerHTML;
  await addUser();
  event.target = document.getElementById("suche");
  autoComplete(event);
  document.getElementById("suche").focus();
}

/**
 * adds a user to the invitation selection
 */
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

/**
 * builds the list of users that are currently invited
 */
function buildUserList() {

  // clear previous selection
  document.getElementById("antwort").innerHTML = "";

  // create elements for every user that is currently in the selection
  for (let curUser of userList) {

    // build container
    let newUserElement = document.createElement("div");
    newUserElement.classList.add("list-group-item");
    newUserElement.classList.add("flex");
    newUserElement.classList.add("align-items-center");
    newUserElement.setAttribute("id", "User" + curUser);

    // build remove button
    let deleteButton = document.createElement("button");
    deleteButton.classList.add("btn-close");
    deleteButton.classList.add("btn-sm")
    deleteButton.addEventListener("click", removeUser);
    deleteButton.setAttribute("type", "button");
    deleteButton.setAttribute("id", "btnUser" + curUser);
    deleteButton.setAttribute("aria-label", "Close");

    // build text node
    let userTextNode = document.createTextNode(" " + curUser);

    // add elements to document
    newUserElement.appendChild(deleteButton);
    newUserElement.appendChild(userTextNode);
    document.getElementById("antwort").appendChild(newUserElement);
  }
}

/**
 * removes a user form the invitation selection
 *
 * @param {Event} event
 */
function removeUser(event) {
  userName = event.target.id.substring(7);
  userIndex = userList.indexOf(userName);
  userList.splice(userIndex, 1);

  buildUserList();
};

// --------- Epic functions -----------------------------------------

/**
 * switches between selecting or creating an epic
 *
 * @param {Event} event
 */
function switchEpic(event) {
  let switchTo;
  if (event.target.id === "btnSwitchEpicCreate") {
    switchTo = "Create";
  } else if (event.target.id === "btnSwitchEpicSelect") {
    switchTo = "Select";
  } else {
    return;
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

/**
 * event when a suggestion in the epicName search bar is accepted
 *
 * @param {Event} event
 */
async function acceptSuggestionEpic(event) {
  event.preventDefault();
  document.getElementById("sucheEpic").value = event.target.innerHTML;
  await addEpic();
  event.target = document.getElementById("sucheEpic");
  autoComplete(event);
  document.getElementById("sucheEpic").focus();
}

/**
 * search for epics on the server whose name start with given input
 *
 * @param {String} input epicName to search for
 */
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

/**
 * selects an epic
 */
async function addEpic() {
  let input = document.getElementById("sucheEpic").value;
  let foundEpics = await searchEpics(input);
  let epicExists = false;

  // check if epic with searched name exists
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

/**
 * builds the element of the selected epic
 *
 * @param {String} epicName name of the selected epic
 */
function buildEpic(epicName) {

  // clear previous selections
  document.getElementById("epicSelected").innerHTML = "";

  // create container
  let epicElement = document.createElement("div");
  epicElement.classList.add("list-group-item");
  epicElement.classList.add("flex");
  epicElement.classList.add("align-items-center");

  // create remove button
  let deleteButton = document.createElement("button");
  deleteButton.classList.add("btn-close");
  deleteButton.classList.add("btn-sm")
  deleteButton.addEventListener("click", removeEpic);
  deleteButton.setAttribute("type", "button");
  deleteButton.setAttribute("aria-label", "Close");

  // create text node
  let epicTextNode = document.createTextNode(" " + epicName);

  // add element to selection
  epicElement.appendChild(deleteButton);
  epicElement.appendChild(epicTextNode);
  document.getElementById("epicSelected").appendChild(epicElement);
}

/**
 * removes previously selected epic
 */
function removeEpic() {
  epicName = "";
  document.getElementById("epicSelected").innerHTML = "";
  document.getElementById("epicSelect").classList.remove("d-none");
}

// add event listeners
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
