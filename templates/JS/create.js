async function autoComplete() {
  let input = document.getElementById("suche");
  let foundUsernames = [];
  if (input.value !== "") {
    let antwort = await fetch("Game/Search?userName=" + input.value);
    foundUsernames = await antwort.json();
    if (foundUsernames === {}) {
      foundUsernames = [];
    }
  }
  document.getElementById("suggestions").innerHTML = "";
  createSuggestions(foundUsernames);
}

function createSuggestions(list) {
  let suggestions = document.getElementById("suggestions");
  let input = document.getElementById("suche");
  for (let curSuggestion of list) {
    if (input.value == curSuggestion) {
      continue;
    }
    let newElement = document.createElement("button");
    newElement.classList.add("list-group-item");
    newElement.addEventListener("click", acceptSuggestion)
    newElement.innerHTML=curSuggestion;
    suggestions.appendChild(newElement);
  }
}

function acceptSuggestion(event) {
  event.preventDefault();
  document.getElementById("suche").value = event.target.innerHTML;
  autoComplete();
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("suche").addEventListener("input", autoComplete);
  document.getElementById("suche").addEventListener("change", autoComplete);
});
