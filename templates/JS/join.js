let c
function expand(event) {
    if (c != null) {
        c.classList.add("secondaryPartHidden");
    }
    event.target.children[3].classList.remove("secondaryPartHidden");
    c = event.target.children[3];
}
