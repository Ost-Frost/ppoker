let notificationTimeout = false;

function addNotification(text, level) {
    if (notificationTimeout) {
        clearInterval(notificationTimeout);
    }

    setNotificationLevel(level);
    document.getElementById("notification").classList.remove("d-none");
    document.getElementById("notificationText").innerHTML = text;

    notificationTimeout = setTimeout(closeNotification, 5000);
}

function setNotificationLevel(level) {
    document.getElementById("notificationAlert").classList.remove("alert-primary");
    document.getElementById("notificationAlert").classList.remove("alert-warning");
    document.getElementById("notificationAlert").classList.remove("alert-danger");
    document.getElementById("notificationAlert").classList.remove("alert-success");

    let newClass = "alert-primary";
    switch (level) {
        case "information" : newClass = "alert-primary"; break;
        case "warning": newClass = "alert-warning"; break;
        case "error": newClass = "alert-danger"; break;
        case "success": newClass = "alert-success"; break;
    }

    document.getElementById("notificationAlert").classList.add(newClass);
}

function closeNotification() {
    if (notificationTimeout) {
        notificationTimeout = false;
    }

    document.getElementById("notification").classList.add("d-none");
    document.getElementById("notificationText").innerHTML = "";
}

// add event listeners
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("notificationClose").addEventListener("click", closeNotification);
});