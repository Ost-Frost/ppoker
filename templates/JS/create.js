async function a() {
    let antwort = await fetch("Create/Search?userName=6");
    let text = await antwort.text();
    document.getElementById("antwort").innerHTML = text;
  }
