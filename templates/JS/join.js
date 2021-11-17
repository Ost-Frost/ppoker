let c;
function expand(event) {
    if (c != null) {
        c.children[5].classList.add("secondaryPartHidden");
        c.children[2].classList.remove("secondaryPartHidden");
        c.children[3].classList.add("secondaryPartHidden");
    }
    c = event.target;
    c.children[5].classList.remove("secondaryPartHidden");
    c.children[2].classList.add("secondaryPartHidden");
    c.children[3].classList.remove("secondaryPartHidden");
    console.log(c.children[5]);
}