let notificationTimeout = false;
let notificationTimer = false;

function addNotification(text, level) {
    if (notificationTimeout) {
        clearInterval(notificationTimeout);
    }
    resetTimer();

    setNotificationLevel(level);
    document.getElementById("notification").classList.remove("d-none");
    document.getElementById("notificationText").innerHTML = text;

    notificationTimeout = setTimeout(closeNotification, 5000);
    notificationTimer = setTimeout(updateTimer, 1000);
}

function setNotificationLevel(level) {
    document.getElementById("notificationAlert").classList.remove("alert-primary");
    document.getElementById("notificationAlert").classList.remove("alert-warning");
    document.getElementById("notificationAlert").classList.remove("alert-danger");
    document.getElementById("notificationAlert").classList.remove("alert-success");
    document.getElementById("notificationProgress").classList.remove("bg-info");
    document.getElementById("notificationProgress").classList.remove("bg-warning");
    document.getElementById("notificationProgress").classList.remove("bg-danger");
    document.getElementById("notificationProgress").classList.remove("bg-success");

    let newClass = "alert-primary";
    let newProgress="bg-info";
    switch (level) {
        case "information" : newClass = "alert-primary"; newProgress="bg-info"; break;
        case "warning": newClass = "alert-warning"; newProgress="bg-warning"; break;
        case "error": newClass = "alert-danger"; newProgress="bg-danger"; break;
        case "success": newClass = "alert-success"; newProgress="bg-success"; break;
    }

    document.getElementById("notificationAlert").classList.add(newClass);
    document.getElementById("notificationProgress").classList.add(newProgress);
}

function closeNotification() {
    if (notificationTimeout) {
        notificationTimeout = false;
    }
    resetTimer();

    document.getElementById("notification").classList.add("d-none");
    document.getElementById("notificationText").innerHTML = "";
}

function updateTimer() {
    let progressBar = document.getElementById("notificationProgress");
    if (progressBar.classList.contains("w20")) {
        progressBar.classList.remove("w20");
        progressBar.classList.add("w100");
        progressBar.setAttribute("aria-valuenow", (100));
        notificationTimer = false;
    } else {
        let progressLevels = [40, 60, 80, 100];
        progressLevels.forEach((level) => {
            if (progressBar.classList.contains("w" + level)) {
                progressBar.classList.remove("w" + level);
                progressBar.classList.add("w" + (level-20));
                progressBar.setAttribute("aria-valuenow", (level-20));
            }
        });
        notificationTimer = setTimeout(updateTimer, 1000);
    }
}

function resetTimer() {
    if (notificationTimer) {
        clearInterval(notificationTimer);
    }
    notificationTimer = false;
    let progressBar = document.getElementById("notificationProgress");
    let progressLevels = [20, 40, 60, 80];
    progressLevels.forEach((level) => {
        if (progressBar.classList.contains("w" + level)) {
            progressBar.classList.remove("w" + level);
            progressBar.classList.add("w100");
            progressBar.setAttribute("aria-valuenow", 100);
        }
    });
}

// add event listeners
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("notificationClose").addEventListener("click", closeNotification);
});