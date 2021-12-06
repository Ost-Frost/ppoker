let s; //Game
let e;
function epic(event) {
    let parent = event.target.parentNode;
    if (e != null) {
        e.children[0].classList.remove("d-none");
        e.children[1].classList.add("d-none");
        parent.children[2].classList.add("d-none");
    }
    e = event.target;
    e.children[0].classList.add("d-none");
    e.children[1].classList.remove("d-none");
    parent.children[2].classList.remove("d-none");
}
function expand(event) {
    if (s != null) {
        s.children[5].classList.add("d-none");
        s.children[2].classList.remove("d-none");
        s.children[3].classList.add("d-none");
    }
    s = event.target;
    s.children[5].classList.remove("d-none");
    s.children[2].classList.add("d-none");
    s.children[3].classList.remove("d-none");
}
