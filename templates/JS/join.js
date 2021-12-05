let s;
function epic(event) {
    e = event.target;
    alert(e);
}
function expand(event) {
    if (s != null) {
        s.children[5].classList.add("hidden");
        s.children[2].classList.remove("hidden");
        s.children[3].classList.add("hidden");
    }
    s = event.target;
    s.children[5].classList.remove("hidden");
    s.children[2].classList.add("hidden");
    s.children[3].classList.remove("hidden");
}

