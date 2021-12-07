<<<<<<< HEAD
let s; //Game 
let e; 
function epic(event) {
    let parent = event.target.parentNode;
    if (e != null) {
        e.children[0].classList.remove("hidden");
        e.children[1].classList.add("hidden");
        e.parentNode.children[2].classList.add("hidden");
    }
    e = event.target;
    e.children[0].classList.add("hidden");
    e.children[1].classList.remove("hidden");
    e.parentNode.children[2].classList.remove("hidden");
=======
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
>>>>>>> 01c1c021755af60baabcaa6846afa6e7eb62b133
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
