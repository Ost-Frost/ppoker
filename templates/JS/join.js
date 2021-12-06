let s; //Game 
let e;
function epic(event) {
    let parent = event.target.parentNode;
    if (e != null) {
        e.children[0].classList.remove("hidden");
        e.children[1].classList.add("hidden");
        parent.children[2].classList.add("hidden");
    }
    e = event.target;
    e.children[0].classList.add("hidden");
    e.children[1].classList.remove("hidden");
    parent.children[2].classList.remove("hidden");
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

